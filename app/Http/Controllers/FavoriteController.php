<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        
        $favorites = $currentUser->favorites()
            ->with(['primaryPhoto', 'facilities', 'activities'])
            ->where('is_active', true)
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    public function store(Cafe $cafe)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        
        $exists = $currentUser->favorites()->where('cafe_id', $cafe->id)->exists();
        
        if (!$exists) {
            $currentUser->favorites()->attach($cafe->id);
            return back()->with('success', 'Café berhasil ditambahkan ke favorit!');
        }

        return back()->with('info', 'Café sudah ada di favorit Anda!');
    }

    public function destroy(Cafe $cafe)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();
        $currentUser->favorites()->detach($cafe->id);
        
        return back()->with('success', 'Café berhasil dihapus dari favorit!');
    }
}
