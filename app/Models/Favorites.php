<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use HasFactory;

    protected $primaryKey = 'idFavorites';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idFavorites',
        'dateSaved',
        'user_id',
        'property_id',
    ];

    public function favorites()
    {
        return $this->belongsTo(Favorites::class, 'idFavorites');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function property()
    {
        return $this->belongsTo(Properties::class, 'property_id');
    }

}
