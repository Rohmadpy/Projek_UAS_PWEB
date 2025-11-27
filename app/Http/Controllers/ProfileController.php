<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        return view('profile.index', ['user' => $currentUser]);
    }

    public function update(Request $request)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($currentUser->id)],
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        // Update basic info
        $currentUser->name = $validated['name'];
        $currentUser->email = $validated['email'];
        $currentUser->phone = $validated['phone'] ?? null;

        // Update avatar
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($currentUser->avatar) {
                Storage::disk('public')->delete($currentUser->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $currentUser->avatar = $avatarPath;
        }

        // Update password
        if ($request->filled('new_password')) {
            $currentPassword = $request->input('current_password');
            
            if (!Hash::check($currentPassword, $currentUser->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah!']);
            }

            $currentUser->password = Hash::make($validated['new_password']);
        }

        $currentUser->save();

        return back()->with('success', 'Profil berhasil diupdate!');
    }
}
