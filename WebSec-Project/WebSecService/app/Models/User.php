<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // ← Add this
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail // ← Implement this
{
    use HasApiTokens,
        HasFactory,
        Notifiable,
        HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function purchases()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('quantity', 'location', 'payment_method')
                    ->withTimestamps();
    }
    
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }


    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
}

