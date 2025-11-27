<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Facility;
use App\Models\ActivityCategory;
use App\Models\CafePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminCafeController extends Controller
{
    public function index()
    {
        $cafes = Cafe::with(['primaryPhoto'])
            ->latest()
            ->paginate(15);

        return view('admin.cafes.index', compact('cafes'));
    }

    public function create()
    {
        $facilities = Facility::all();
        $activities = ActivityCategory::all();

        return view('admin.cafes.create', compact('facilities', 'activities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer|min:1',
            'price_range' => 'required|in:$,$$,$$$',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'atmosphere' => 'required|in:tenang,ramai,cozy,estetik',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'activities' => 'nullable|array',
            'activities.*' => 'exists:activity_categories,id',
            'photos' => 'required|array|min:1',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'primary_photo' => 'required|integer|min:0',
        ]);

        // Create slug
        $slug = Str::slug($validated['name']);
        $originalSlug = $slug;
        $counter = 1;

        while (Cafe::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Create cafe
        $cafe = Cafe::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'district' => $validated['district'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'phone' => $validated['phone'],
            'capacity' => $validated['capacity'],
            'price_range' => $validated['price_range'],
            'open_time' => $validated['open_time'],
            'close_time' => $validated['close_time'],
            'atmosphere' => $validated['atmosphere'],
            'is_active' => true,
        ]);

        // Attach facilities
        if (!empty($validated['facilities'])) {
            $cafe->facilities()->attach($validated['facilities']);
        }

        // Attach activities
        if (!empty($validated['activities'])) {
            $cafe->activities()->attach($validated['activities']);
        }

        // Upload photos
        if ($request->hasFile('photos')) {
            $primaryIndex = $validated['primary_photo'];

            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('cafe-photos', 'public');

                CafePhoto::create([
                    'cafe_id' => $cafe->id,
                    'photo_path' => $path,
                    'is_primary' => $index == $primaryIndex,
                ]);
            }
        }

        return redirect()->route('admin.cafes.index')
            ->with('success', 'Café berhasil ditambahkan!');
    }

    public function show(Cafe $cafe)
    {
        $cafe->load(['photos', 'facilities', 'activities', 'reviews.user']);

        return view('admin.cafes.show', compact('cafe'));
    }

    public function edit(Cafe $cafe)
    {
        $facilities = Facility::all();
        $activities = ActivityCategory::all();
        $cafe->load(['photos', 'facilities', 'activities']);

        return view('admin.cafes.edit', compact('cafe', 'facilities', 'activities'));
    }

    public function update(Request $request, Cafe $cafe)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer|min:1',
            'price_range' => 'required|in:$,$$,$$$',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i|after:open_time',
            'atmosphere' => 'required|in:tenang,ramai,cozy,estetik',
            'is_active' => 'boolean',
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
            'activities' => 'nullable|array',
            'activities.*' => 'exists:activity_categories,id',
            'new_photos' => 'nullable|array',
            'new_photos.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'primary_photo' => 'nullable|integer',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'exists:cafe_photos,id',
        ]);

        // Update slug if name changed
        if ($cafe->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $counter = 1;

            while (Cafe::where('slug', $slug)->where('id', '!=', $cafe->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $validated['slug'] = $slug;
        }

        // Update cafe
        $cafe->update($validated);

        // Sync facilities
        $cafe->facilities()->sync($validated['facilities'] ?? []);

        // Sync activities
        $cafe->activities()->sync($validated['activities'] ?? []);

        // Delete photos if requested
        if (!empty($validated['delete_photos'])) {
            foreach ($validated['delete_photos'] as $photoId) {
                $photo = CafePhoto::find($photoId);
                if ($photo && $photo->cafe_id == $cafe->id) {
                    Storage::disk('public')->delete($photo->photo_path);
                    $photo->delete();
                }
            }
        }

        // Upload new photos
        if ($request->hasFile('new_photos')) {
            foreach ($request->file('new_photos') as $photo) {
                $path = $photo->store('cafe-photos', 'public');

                CafePhoto::create([
                    'cafe_id' => $cafe->id,
                    'photo_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        // Update primary photo
        if ($request->filled('primary_photo')) {
            CafePhoto::where('cafe_id', $cafe->id)->update(['is_primary' => false]);
            CafePhoto::where('id', $validated['primary_photo'])
                ->where('cafe_id', $cafe->id)
                ->update(['is_primary' => true]);
        }

        return redirect()->route('admin.cafes.index')
            ->with('success', 'Café berhasil diupdate!');
    }

    public function destroy(Cafe $cafe)
    {
        // Delete all photos
        foreach ($cafe->photos as $photo) {
            Storage::disk('public')->delete($photo->photo_path);
        }

        $cafe->delete();

        return redirect()->route('admin.cafes.index')
            ->with('success', 'Café berhasil dihapus!');
    }
}