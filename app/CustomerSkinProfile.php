<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerSkinProfile extends Model
{
    //Specify the table name
    public $table = 'customer_skin_profiles';
    
    // Mass assignable fields
    protected $fillable = [
        'contact_id', 'status' , 'content'        
    ];
	// relationship between contacts and contacts_medications
	public function profile() {
        return $this->belongsTo(contacts::class, 'contact_id');
    }
}
