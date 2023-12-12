<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_comments extends Model
{
    use HasFactory;
    protected $primaryKey = 'idUserComments';

    protected $fillable = [
        'idUserComments',
        'comment',
        'commentDate',
        'sender_user_id',
        'receiver_user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}
