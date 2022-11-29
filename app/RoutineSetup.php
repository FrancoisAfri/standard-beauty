<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoutineSetup extends Model
{
    //Specify the table name
    public $table = 'routine_setups';
    
    // Mass assignable fields
    protected $fillable = [
        'document_root'        
    ];
}
