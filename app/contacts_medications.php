<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contacts_medications extends Model
{
     //Specify the table name
    public $table = 'contacts_medications';
    
    // Mass assignable fields
    protected $fillable = [
        'contact_id', 'medication'        
    ];
	// relationship between contacts and contacts_medications
	public function contact() {
        return $this->belongsTo(contacts::class, 'contact_id');
    }
       
}
