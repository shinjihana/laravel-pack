<?php

namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Reply extends Model
{
    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
