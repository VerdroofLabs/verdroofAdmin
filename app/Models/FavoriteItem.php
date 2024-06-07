<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteItem extends Model
{
    use HasFactory;

    public function favorite()
    {
        return $this->belongsTo(Favorite::class);
    }

    public function property()
    {
        return $this->hasOne(Property::class, 'id', 'property_id');
    }
}
