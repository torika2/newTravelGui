<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	public function userPost()
	{
		return $this->belongsTo(User::class,'user_id');
	}
    public function postLike()
    {
    	return $this->hasMany(PostLike::class,'post_id');
    }
    public function postShare()
    {
    	return $this->hasMany(PostShare::class,'post_id');
    }
    public function postFavourite()
    {
    	return $this->hasMany(PostFavourite::class,'post_id');
    }
}
