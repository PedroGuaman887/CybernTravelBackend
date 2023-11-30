<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    use HasFactory;
    protected $primaryKey = 'idRatings';

    protected $fillable = [
        'idRatings',
        'ratingCleaning',    
        'ratingPunctuality' ,
        'ratingFriendliness',
        'ratingComment',
        'idUser',
        'idProperty',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function property()
    {
        return $this->belongsTo(Properties::class, 'idProperty');
    }

}
