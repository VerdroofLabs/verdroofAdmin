<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $casts = [
        'other_images' => 'array',
        'basic_amenities' => 'array',
        'building_amenities' => 'array',
        'house_rules' => 'array',
        'safety_amenities' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
