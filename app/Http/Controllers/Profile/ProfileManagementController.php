<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $profiles = Profile::where('tenant_id', $request->user()->tenant_id)
            ->with('user')
            ->paginate(10);

        return view('profile.management.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('tenant_id', auth()->user()->tenant_id)
            ->whereDoesntHave('profile')
            ->get();

        return view('profile.management.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfileUpdateRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validated['tenant_id'] = auth()->user()->tenant_id;
        $validated['notifications_enabled'] = $request->boolean('notifications_enabled');

        $profile = Profile::create($validated);

        return redirect()->route('profile.show', $profile)
            ->with('success', 'Profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        abort_if($profile->tenant_id !== auth()->user()->tenant_id, 403);

        return view('profile.management.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile)
    {
        abort_if($profile->tenant_id !== auth()->user()->tenant_id, 403);

        return view('profile.management.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProfileUpdateRequest $request, Profile $profile)
    {
        abort_if($profile->tenant_id !== auth()->user()->tenant_id, 403);

        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $validated['notifications_enabled'] = $request->boolean('notifications_enabled');

        $profile->update($validated);

        return redirect()->route('profile.show', $profile)
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        abort_if($profile->tenant_id !== auth()->user()->tenant_id, 403);

        if ($profile->avatar) {
            Storage::disk('public')->delete($profile->avatar);
        }

        $profile->delete();

        return redirect()->route('profile.index')
            ->with('success', 'Profile deleted successfully.');
    }
}
