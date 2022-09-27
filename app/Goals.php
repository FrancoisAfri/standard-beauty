<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
      //Specify the table name
    public $table = 'goals';
    
    // Mass assignable fields
    protected $fillable = [
        'status', 'title', 'description'
        
    ];
	// relationship between routine and goals
	public function routine()
    {
		return $this->hasOne(Routines::class, 'goal_id');
    }
	// get all goals
	public static function getAllGoals($status = 1)
    {
		$query = Goals::
				where('status', $status)
				->orderBy('title', 'asc');
        return $query->get();
    }
}
