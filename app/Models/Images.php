<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;

    protected $primaryKey = 'idImages';

    protected $fillable = [
        'idImages',
        'imageLink',
        'imageDescription',
    ];

    public function properties()
    {
        return $this->belongsToMany(Properties::class, 'properties_images', 'image_id', 'property_id');
    }
}
