<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsReview extends Model
{
	//Specify the table name
    public $table = 'products_reviews';

    //Mass assignable fields
    protected $fillable = [
        'product_name', 'notes', 'picture', 'contact_id'
    ];

    public function userReview()
    {
        return $this->belongsTo(contacts::class, 'contact_id');
    }
	// get all active news
	public static function getReviews($contactid)
	{
		$query = ProductsReview::
				where('contact_id', $contactid)
				->orderBy('product_name', 'asc');
		return $query->get();
	}
}
