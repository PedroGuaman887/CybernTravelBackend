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
         'propertyStartA',
         'propertyEndA',
         'propertyStartB',
         'propertyEndB',
         'propertyStartC',
         'propertyEndC',
         'propertyStartD',
         'propertyEndD',
         'propertyStartE',
         'propertyEndE',
         'propertyStartF',
         'propertyEndF',
         'propertyStartG',
         'propertyEndG',
         'propertyStartH',
         'propertyEndH',
         'propertyAmountA',
         'propertyAmountB', 
         'propertyAmountC', 
         'propertyAmountD', 
         'propertyAmountE', 
         'propertyAmountF', 
         'propertyAmountG', 
         'propertyAmountH'
    ];
}
