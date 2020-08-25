<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewCategory extends Model
{
    protected $fillable=[
        'is_parent',
        'has_parent',
        'parent_id',
        'image_id',
        'name',
        'url_en_name',
        'deleted',
    ];

    public function image(){

        return $this->belongsTo('App\Image');

    }
}
