<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function toggleActive(User $user)
    {
        // Prevent toggling admin accounts
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat mengubah status admin!');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "User berhasil {$status}!");
    }

    public function resetPassword(User $user)
    {
        // Prevent resetting admin passwords
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat mereset password admin!');
        }

        $newPassword = 'password123';
        $user->update(['password' => Hash::make($newPassword)]);

        return back()->with('success', "Password user berhasil direset menjadi: {$newPassword}");
    }
}