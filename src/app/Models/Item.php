<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'img_url', 'brand', 'price', 'color', 'description', 'category', 'condition', 'comment',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function favorites() {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }
}
