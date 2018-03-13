<?php

namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Thread extends Model
{

    protected $guarded = [];
    
    public function path(){
        return '/threads/'. $this->id;
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply){
        $this->replies()->create($reply);
    }
}
