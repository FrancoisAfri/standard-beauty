<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoutineLink extends Model
{
    //Specify the table name
    public $table = 'routines_link';
    
    // Mass assignable fields
    protected $fillable = [
        'status', 'routine_id', 'picture', 'hyper_link'        
    ];

}
