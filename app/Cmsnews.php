<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cmsnews extends Model
{
    //Specify the table name
    public $table = 'cms_news';

    //Mass assignable fields
    protected $fillable = [
        'name', 'link', 'expirydate', 'supporting_docs', 'summary', 'image', 'user_id', 'status', 'adv_number'
    ];

    public function cmsRankings()
    {
        return $this->hasMany(cms_rating::class, 'cms_id');
    }
}
