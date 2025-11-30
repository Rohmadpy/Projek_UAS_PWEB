<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'city',
        'district',
        'latitude',
        'longitude',
        'phone',
        'capacity',
        'price_range',
        'open_time',
        'close_time',
        'atmosphere',
        'avg_rating',
        'total_reviews',
        'is_active',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'avg_rating' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'open_time' => 'datetime:H:i',   // ← TAMBAH INI
        'close_time' => 'datetime:H:i',  // ← TAMBAH INI
    ];

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'cafe_facility')->withTimestamps();
    }

    public function activities()
    {
        return $this->belongsToMany(ActivityCategory::class, 'cafe_activity')->withTimestamps();
    }

    public function photos()
    {
        return $this->hasMany(CafePhoto::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function primaryPhoto()
    {
        return $this->hasOne(CafePhoto::class)->where('is_primary', true);
    }

    public function updateRating()
    {
        $approved = $this->reviews()->where('status', 'approved');
        $this->avg_rating = $approved->avg('rating') ?? 0;
        $this->total_reviews = $approved->count();
        $this->save();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}