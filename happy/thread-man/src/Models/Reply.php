<?php

namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

    protected $guarded = [];
    
    protected $with = ['owner', 'favorites'];

    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }
}
