<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusProperty extends Model
{
    use HasFactory;
    protected $primaryKey = 'idStatus';
    protected $fillable = [
        'status',
        'startDate',
        'endDate'
    ];
}
