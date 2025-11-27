<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\User;
use App\Models\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_cafes' => Cafe::count(),
            'active_cafes' => Cafe::where('is_active', true)->count(),
            'total_users' => User::where('role', 'user')->count(),
            'active_users' => User::where('role', 'user')->where('is_active', true)->count(),
            'pending_reviews' => Review::where('status', 'pending')->count(),
            'approved_reviews' => Review::where('status', 'approved')->count(),
        ];

        $recent_reviews = Review::with(['cafe', 'user'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        $top_cafes = Cafe::where('is_active', true)
            ->orderBy('avg_rating', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_reviews', 'top_cafes'));
    }
}