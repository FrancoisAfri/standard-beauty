<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contacts extends Model
{
     //Specify the table name
    public $table = 'contacts';
    
    // Mass assignable fields
    protected $fillable = [
        'firstname', 'surname', 'email', 'status', 'cell_number', 'picture', 'address', 'on_medication'        
    ];
	
	
    public function medication() {
        return $this->hasMany(contacts_medications::class, 'contact_id');
    }
	
	public function skinProfile() {
        return $this->hasMany(CustomerSkinProfile::class, 'contact_id');
    }
	
	public function challenges() {
        return $this->hasMany(challengesUsers::class, 'contact_id');
    }
	
	public function challengesProgess() {
        return $this->hasMany(challengesProgress::class, 'contact_id');
    }
	public function progess() {
        return $this->hasMany(CustomerProgress::class, 'contact_id');
    }
	public function review() {
        return $this->hasMany(ProductsReview::class, 'contact_id');
    }
	public function reminder() {
        return $this->hasMany(CustomerReminder::class, 'contact_id');
    }
	
	//Relationship contacts and contacts_users
	public function user() {
        return $this->belongsTo(contacts_users::class, 'user_id');
    }
	// get all clients
	public static function getAllCustomers($status = 1)
    {
		
		if ($status == 1) 
		{
			$query = contacts::where([
			'status' => $status
			]);
		}
		else
		{
			//echo die('kdnnnf');
			$query = contacts::where('status', '<>', 1);
		}

        return $query->get();
    }
}
