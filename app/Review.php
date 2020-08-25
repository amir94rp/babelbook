<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable=[
        'title',
        'review_writer_id',
        'review_category_id',
        'published',
        'description',
        'tags',
        'is_tags_visible',
        'publish_date',
        'image_id',
    ];

    public function image(){

        return $this->belongsTo('App\Image');

    }

    public function category(){

        return $this->belongsTo('App\ReviewCategory','review_category_id');

    }

    public function writer(){

        return $this->belongsTo('App\ReviewWriter','review_writer_id');

    }
}
