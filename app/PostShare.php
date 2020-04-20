<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostShare extends Model
{
    public function post()
    {
    	return $this->hasMany(Post::class,'post_id');
    }
}
