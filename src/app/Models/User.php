<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'postcode', 'address', 'build', 'image',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function items() {
        return $this->hasMany(Item::class);
    }

    public function favorites() {
        return $this->belongsToMany(Item::class, 'favorites');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function purchases() {
        return $this->hasMany(Purchase::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}