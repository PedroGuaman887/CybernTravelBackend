<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{
    use HasFactory;
    protected $primaryKey = 'idReservations';
    protected $fillable=[
        'idReservations',
        'datePayment',
        'status',
        'startDate',
        'endDate',
        'idUser',
        'idProperty',
    ];



    public function request()
    {
        return $this->belongsTo(Requests::class, 'idRequests');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }

    public function property()
    {
        return $this->belongsTo(Properties::class, 'idProperty');
    }
}
