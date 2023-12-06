<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsUsers extends Model
{
    use HasFactory;

    protected $primaryKey = 'idNotificationsUsers';
    protected $fillable=[
        'idNotificationsUsers',
        'nameProperty',
        'nameHost',
        'phoneHost',
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
