<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    use HasFactory;
    protected $primaryKey = 'idRating';

    protected $fillable = [
        'idRating',
        'ratingStar',
        'ratingComment',
    ];

    public function properties()
    {
        return $this->belongsToMany(Properties::class, 'properties_ratings', 'rating_id', 'property_id');
    }
}
