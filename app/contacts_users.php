<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contacts_users extends Model
{
     //Specify the table name
    public $table = 'contacts_users';
    
    // Mass assignable fields
    protected $fillable = [
        'status', 'email', 'password'
        
    ];
	// relationship between contacts and contacts_users
	public function person()
    {
		return $this->hasOne(contacts::class, 'user_id');
    }
}
