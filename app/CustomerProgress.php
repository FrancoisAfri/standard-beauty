<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProgress extends Model
{
    //Specify the table name
	public $table = 'customer_progresses';

	// Mass assignable fields
	protected $fillable = [
		'contact_id', 'picture','comment'       
	];
			  
	 //Relationship contacts and 
	public function user() {
		return $this->belongsTo(contacts::class, 'contact_id');
	}         

	// get all challenges
	public static function getAllCustomerProgress($user)
	{
		$query = CustomerProgress::where(['contact_id' => $user])
				->orderBy('id', 'asc');
		return $query->get();
	}
}
