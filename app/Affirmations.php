<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affirmations extends Model
{
   //Specify the table name
         public $table = 'affirmations';
    
         // Mass assignable fields
         protected $fillable = [
             'affirmation','status'       
         ];
                 
		// get all affirmation
		public static function getAffirmations($status = 1)
		{
			$query = Affirmations::
					where('status', $status);
					//->where('created_at', '<=', date('Y-m-d').' 00:00:00')
					//->whereDate('date_to', '<=', $date)
					//->orderBy('title', 'asc');
			return $query->get();
		}
}
