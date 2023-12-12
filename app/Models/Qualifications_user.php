<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualifications_user extends Model
{
    use HasFactory;
    protected $primaryKey = 'idQualificationUser';

    protected $fillable = [
        'idQualificationUser',
        'ratingCleaning',
        'ratingPunctuality',
        'ratingComunication',
        'qualificationAmount',
        'idUser',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'idUser');
    }
}
