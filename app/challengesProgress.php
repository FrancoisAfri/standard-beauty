<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class challengesProgress extends Model
{
		//Specify the table name
        public $table = 'challenges_progresses';
    
        // Mass assignable fields
        protected $fillable = [
            'challenge_id', 'contact_id', 'picture','comment'       
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
		public static function getAllProgress($user, $challenge)
		{
			$query = challengesUsers::where(['contact_id' => $user, 'challenge_id' => $challenge])
					->orderBy('id', 'asc');
			return $query->get();
		}
}
