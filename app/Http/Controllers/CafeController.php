<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Facility;
use App\Models\ActivityCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CafeController extends Controller
{
    public function index(Request $request)
    {
        $query = Cafe::query()
            ->with(['primaryPhoto', 'facilities', 'activities'])
            ->where('is_active', true);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Filter by district
        if ($request->filled('district')) {
            $query->where('district', $request->district);
        }

        // Filter by facilities
        if ($request->filled('facilities')) {
            $query->whereHas('facilities', function ($q) use ($request) {
                $q->whereIn('facilities.id', $request->facilities);
            });
        }

        // Filter by activities
        if ($request->filled('activities')) {
            $query->whereHas('activities', function ($q) use ($request) {
                $q->whereIn('activity_categories.id', $request->activities);
            });
        }

        // Filter by price range
        if ($request->filled('price_range')) {
            $query->where('price_range', $request->price_range);
        }

        // Filter by atmosphere
        if ($request->filled('atmosphere')) {
            $query->where('atmosphere', $request->atmosphere);
        }

        // Sort
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'rating':
                    $query->orderBy('avg_rating', 'desc');
                    break;
                case 'reviews':
                    $query->orderBy('total_reviews', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                default:
                    $query->orderBy('avg_rating', 'desc');
            }
        } else {
            $query->orderBy('avg_rating', 'desc');
        }

        $cafes = $query->paginate(12)->withQueryString();

        $facilities = Facility::all();
        $activities = ActivityCategory::all();
        $cities = Cafe::distinct()->pluck('city');

        return view('cafes.index', compact('cafes', 'facilities', 'activities', 'cities'));
    }

    public function show(string $slug)
    {
        $cafe = Cafe::query()
            ->with(['photos', 'facilities', 'activities', 'approvedReviews.user'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $isFavorited = false;
        $userHasReviewed = false;

        if (Auth::check()) {
            /** @var User $currentUser */
            $currentUser = Auth::user();
            $isFavorited = $currentUser->favorites()->where('cafe_id', $cafe->id)->exists();
            $userHasReviewed = $cafe->reviews()->where('user_id', $currentUser->id)->exists();
        }

        return view('cafes.show', compact('cafe', 'isFavorited', 'userHasReviewed'));
    }

    public function nearby(Request $request)
    {
        if (!$request->filled('latitude') || !$request->filled('longitude')) {
            return view('cafes.nearby', ['cafes' => collect()]);
        }

        $lat = $request->input('latitude');
        $lng = $request->input('longitude');
        $radius = $request->input('radius', 5); // default 5 km

        $cafes = Cafe::selectRaw("
                *,
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
            ", [$lat, $lng, $lat])
            ->where('is_active', true)
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->with(['primaryPhoto', 'facilities', 'activities'])
            ->get();

        return view('cafes.nearby', compact('cafes', 'lat', 'lng'));
    }
}