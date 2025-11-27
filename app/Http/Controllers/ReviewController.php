<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cafe_id' => 'required|exists:cafes,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $userId = Auth::id();

        // Check if user already reviewed this cafe
        $existingReview = Review::query()
            ->where('cafe_id', $validated['cafe_id'])
            ->where('user_id', $userId)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan review untuk café ini!');
        }

        Review::create([
            'cafe_id' => $validated['cafe_id'],
            'user_id' => $userId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Review berhasil dikirim dan menunggu persetujuan admin!');
    }
}