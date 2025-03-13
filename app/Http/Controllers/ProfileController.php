<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProfileController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'username' => $user->name,
                'description' => null,
                'favorite_characters' => []
            ]
        );
        return view('profiles.show', compact('profile'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile()->firstOrCreate(
            ['user_id' => $user->id],
            [
                'username' => $user->name,
                'description' => null,
                'favorite_characters' => []
            ]
        );
        return view('profiles.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Auth::user()->profile;

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:profiles,username,' . $profile->id,
            'description' => 'nullable|string|max:1000',
            'favorite_characters' => 'nullable|array',
            'favorite_characters.*' => 'string|max:255',
        ]);

        $profile->update($validated);

        return redirect()->route('profiles.show')
            ->with('success', 'Profile updated successfully!');
    }

    public function destroy()
    {
        $profile = Auth::user()->profile;
        $profile->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Profile deleted successfully!');
    }
}