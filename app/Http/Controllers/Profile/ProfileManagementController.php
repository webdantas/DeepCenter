<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileManagementController extends Controller
{
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

    public function index()
    {
        return view('profile.management.index', [
            'profiles' => User::paginate(10)
        ]);
    }

    public function create()
    {
        return view('profile.management.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8'],
            'avatar' => ['nullable', 'image', 'max:1024']
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['avatar'] = $this->handleAvatar($request);

        User::create($validated);

        return redirect()->route('profiles.index')
            ->with('success', 'Profile created successfully');
    }

    public function show(User $profile)
    {
        return view('profile.management.show', compact('profile'));
    }

    public function edit(User $profile)
    {
        return view('profile.management.edit', compact('profile'));
    }

    public function update(Request $request, User $profile)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $profile->id],
            'password' => ['nullable', 'min:8'],
            'avatar' => ['nullable', 'image', 'max:1024']
        ]);

        if ($avatar = $this->handleAvatar($request, $profile->avatar)) {
            $validated['avatar'] = $avatar;
        }

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $profile->update($validated);

        return redirect()->route('profiles.index')
            ->with('success', 'Profile updated successfully');
    }

    public function destroy(User $profile)
    {
        $this->handleAvatar(request(), $profile->avatar);
        $profile->delete();
        
        return redirect()->route('profiles.index')
            ->with('success', 'Profile deleted successfully');
    }
}