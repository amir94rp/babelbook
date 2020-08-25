<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewWriter extends Model
{
    protected $fillable=[
        'name',
        'url_en_name',
        'description',
        'image_id',
        'deleted',
    ];

    public function image(){

        return $this->belongsTo('App\Image');

    }
}
