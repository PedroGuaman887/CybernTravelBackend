<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;
    protected $primaryKey = 'idQualification';

    protected $fillable = [
        'idQualification',
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
    public function property()
    {
        return $this->belongsTo(Properties::class, 'idProperty');
    }

    public function rating()
    {
        return $this->belongsTo(Ratings::class, 'idRatings');
    }
}
