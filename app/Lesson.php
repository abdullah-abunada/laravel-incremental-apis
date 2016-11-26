<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['title', 'body'];

    public function tags(){

        return $this->belongsToMany('App\Tag');
    }

}
