<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holidays extends Model
{
    use HasFactory;

    protected $primaryKey = 'idHolidays';

    protected $fillable = [
        'idHolidays',
        'startDate',
        'endDate',
        'amount',
        'status' 
    ];

    public function properties()
    {
        return $this->belongsToMany(Properties::class, 'properties_holidays', 'holiday_id', 'property_id');
    }
}
