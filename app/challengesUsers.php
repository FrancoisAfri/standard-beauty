<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class challengesUsers extends Model
{
     //Specify the table name
         public $table = 'challenges_users';
    
         // Mass assignable fields
         protected $fillable = [
             'challenge_id', 'contact_id'        
         ];
         
         //Relationship contacts and 
         public function user() {
             return $this->belongsTo(contacts::class, 'contact_id');
         }         
		//Relationship contacts and contacts_users
        public function challenges() {
             return $this->belongsTo(challenges::class, 'challenge_id');
        }
		// get all challenges
		public static function getAllUserChallenges($user)
		{
			$query = challengesUsers::where('contact_id', $user)
					->orderBy('challenge_id', 'asc')
					->with('challenges');
			return $query->get();
		}
}
