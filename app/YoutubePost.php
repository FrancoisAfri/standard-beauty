<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class YoutubePost extends Model
{
    //Specify the table name
    public $table = 'youtube_posts';
    
    // Mass assignable fields
    protected $fillable = [
        'link_post'
    ];
}
