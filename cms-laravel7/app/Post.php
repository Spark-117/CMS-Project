<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $guarded = [];

    public function user(){

        return $this->belongsTo(User::class);
    }

//    //how to use a mutator
//    public function setPostImageAttribute($value){
//
//        $this->attributes['post_image'] = asset($value);
//
//    }

    //using an accessor
//    public function getPostImageAttribute($value)
//    {
//        return asset($value);
//    }


    //This code above will make sure you can use local paths and http paths for your images, so remember it, just in case.

    public function getPostImageAttribute($value)
    {
        if (strpos($value, 'https://') !== false || strpos($value, 'http://') !== false) {
            return $value;
        }
        return asset('storage/' . $value);
    }
}
