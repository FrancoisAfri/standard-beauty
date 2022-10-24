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
		 
		// get all challenges
		public static function getAllChallenges($status = 1)
		{
			$query = challenges::
					where('status', $status)
					->where('created_at', '<=', date('Y-m-d').' 00:00:00')
					//->whereDate('date_to', '<=', $date)
					->orderBy('title', 'asc');
			return $query->get();
		}
		// get all challenges
		public static function getChallenges($status = 1)
		{
			$query = challenges::
					where('status', $status)
					//->whereDate('date_to', '<=', $date)
					->orderBy('title', 'asc');
			return $query->get();
		}
}
