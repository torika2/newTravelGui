<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    public function post()
    {
    	return $this->hasMany(Post::class,'post_id');
    }
}
