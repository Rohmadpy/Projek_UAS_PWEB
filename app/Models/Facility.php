<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'icon'];

    public function cafes()
    {
        return $this->belongsToMany(Cafe::class, 'cafe_facility')->withTimestamps();
    }
}