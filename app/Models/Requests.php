<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;
    protected $primaryKey = 'idRequests';
    protected $fillable=[
        'idRequests',
        'startDate',
        'endDate',
        'dateRequest',
        'status',
        'idUser',
        'idProperty',
    ];

    public function favorites()
    {
        return $this->belongsTo(Favorites::class, 'idRequests');
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
