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
	// get all routine
	public static function getAllRoutines($status = 1, $goalID)
    {
		$query = Routines::
				where('status', $status)
				->where('goal_id',$goalID)
				->orderBy('title', 'asc');
        return $query->get();
    }
}
