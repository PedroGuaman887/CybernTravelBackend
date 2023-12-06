<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsHosts extends Model
{
    use HasFactory;

    protected $primaryKey = 'idNotificationsHosts';
    protected $fillable=[
        'idNotificationsHosts',
        'nameProperty',
        'nameUser',
        'startDate',
        'endDate',
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
