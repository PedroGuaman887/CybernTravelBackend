<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    use HasFactory;
    protected $primaryKey = 'idProperty';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idProperty',
        'propertyName',
        'propertyPicture',
        'propertyOperation',
        'propertyType',
        'propertyAddress',
        'propertyDescription',
        'propertyServices',
        'propertyStatus',
        'propertyAmount',
        'propertyAbility',
        'host_id', 
    ];

    public function holidays()
    {
        return $this->hasMany(Holidays::class, 'properties_holidays', 'property_id', 'holiday_id');
    }
}
