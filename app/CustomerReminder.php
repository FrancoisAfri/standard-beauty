<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerReminder extends Model
{
    //Specify the table name
    public $table = 'customer_reminders';

    //Mass assignable fields
    protected $fillable = [
        'title', 'notes', 'day_of_week', 'time', 'contact_id'
    ];

    public function userReminder()
    {
        return $this->belongsTo(contacts::class, 'contact_id');
    }
	// get all active news
	public static function getReminders($contactid)
	{
		$query = CustomerReminder::
				where('contact_id', $contactid)
				->orderBy('title', 'asc');
		return $query->get();
	}
}
