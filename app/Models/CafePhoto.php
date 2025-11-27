<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CafePhoto extends Model
{
    use HasFactory;

    protected $fillable = ['cafe_id', 'photo_path', 'is_primary'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }
}
