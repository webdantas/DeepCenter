<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Log::info('Profile Update Request', [
            'validated' => $request->validated(),
            'has_file' => $request->hasFile('avatar'),
            'all' => $request->all(),
            'files' => $request->allFiles(),
        ]);

        $validated = $request->validated();
        
        // Handle basic fields
        $request->user()->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Handle avatar upload
        if ($avatar = $this->handleAvatar($request, $request->user()->avatar)) {
            $request->user()->avatar = $avatar;
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed', 'different:current_password'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    protected function handleAvatar(Request $request, ?string $oldAvatar = null): ?string
    {
        if (!$request->hasFile('avatar')) {
            return null;
        }

        // Delete old avatar if exists
        if ($oldAvatar && Storage::disk('public')->exists($oldAvatar)) {
            Storage::disk('public')->delete($oldAvatar);
        }

        $file = $request->file('avatar');
        $filename = time() . '_' . $file->getClientOriginalName();
        
        // Store with explicit avatars path
        return $file->storeAs('avatars', $filename, 'public');
    }
}
