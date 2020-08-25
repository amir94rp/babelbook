<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable=['path'];

    protected $uploads = '/images/';

    public function getPathAttribute($image){

        return $this-> uploads . $image;

    }
}
