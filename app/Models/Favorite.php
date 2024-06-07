<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(FavoriteItem::class);
    }

    public function properties()
    {
        return $this->hasManyThrough(Property::class, FavoriteItem::class, 'favorite_id','id', 'id', 'property_id' );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
