<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class challenges extends Model
{
     //Specify the table name
         public $table = 'challenges';
    
         // Mass assignable fields
         protected $fillable = [
             'title', 'instructions', 'date_from', 'date_to', 'status'        
         ];
         
         public function progess() {
             return $this->hasMany(challengesProgress::class, 'challenge_id');
         }
         public function users() {
             return $this->hasMany(challengesUsers::class, 'challenge_id');
         }
}
