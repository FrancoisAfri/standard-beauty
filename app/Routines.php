<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routines extends Model
{
     //Specify the table name
    public $table = 'routines';
    
    // Mass assignable fields
    protected $fillable = [
        'goal_id', 'title', 'content', 'status'        
    ];
	
	//Relationship routine and Goals
	public function goal() {
        return $this->belongsTo(Goals::class, 'goal_id');
    }
	// relationship between routine and link 
	public function routineLink() {
		return $this->hasMany(RoutineLink::class, 'routine_id');
    }

	// get all routine
	public static function getAllRoutines($status = 1, $goalID)
    {
		$query = Routines::
				where('status', $status)
				->where('goal_id',$goalID)
				->with('routineLink')
				->orderBy('title', 'asc');
        return $query->get();
    }
}
