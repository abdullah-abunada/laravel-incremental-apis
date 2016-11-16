<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function Lesson(){
        return $this->hasMany('App\Lesson');
    }
}
