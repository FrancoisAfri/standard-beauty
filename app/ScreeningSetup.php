<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScreeningSetup extends Model
{
    //Specify the table name
    public $table = 'screenings_setup';
    
    // Mass assignable fields
    protected $fillable = [
        'max_temperature'
        
    ];
}
