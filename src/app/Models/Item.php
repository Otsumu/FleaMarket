<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'image_url', 'brand', 'price', 'color', 'text', 'category', 'status', 'comment',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function favoritedBy() {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
