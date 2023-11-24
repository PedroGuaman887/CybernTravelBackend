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
        'idRequests',
    ];



    public function request()
    {
        return $this->belongsTo(Requests::class, 'idRequests');
    }

}
