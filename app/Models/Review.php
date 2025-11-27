<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'cafe_id',
        'user_id',
        'rating',
        'comment',
        'status',
    ];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::saved(function ($review) {
            $review->cafe->updateRating();
        });

        static::deleted(function ($review) {
            $review->cafe->updateRating();
        });
    }
}