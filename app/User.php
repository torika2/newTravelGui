<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Notifications\MailresetPasswordToken;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',"nickname","lastname"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function roles()
    // {
    //     return $this->belongsToMany('App\UserRole');
    // }

    // public function userFollower()
    // {
    //     return $this->hasMany('App\UserFollower');
    // }

    // public function userTourBookmark()
    // {
    //     return $this->hasMany('App\userTourBookmark');
    // }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }
    public function post()
    {
        return $this->hasMany(Post::class,'user_id');
    }
}
