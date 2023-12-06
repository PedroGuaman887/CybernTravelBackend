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
        'idReservations',
    ];


    protected $dates = ['startDate', 'endDate', 'created_at', 'updated_at'];


    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function property()
    {
        return $this->belongsTo(Properties::class, 'idProperty');
    }

    public function reservations()
    {
    return $this->belongsTo(Reservation::class, 'idReservations');
    }

    
}
