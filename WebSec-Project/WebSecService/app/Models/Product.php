<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model  {

	protected $fillable = [
        'code',
        'name',
        'price',
        'quantity',      
        'model',
        'description',
        'photo',
    ];
     public function buyers()
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps();
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // helper to get average
    public function averageRating()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

}