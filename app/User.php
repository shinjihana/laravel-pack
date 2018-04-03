<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Happy\ThreadMan\UserThreadMan;
use Happy\ThreadMan\Activity;

class User extends Authenticatable
{
    use Notifiable;

    use UserThreadMan;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * Cast
     */
    protected $casts = [
        'confirmed' => 'boolean'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email', 'confirm', 'confirm_token'
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
