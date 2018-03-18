<?php

namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed($user)
    {
        return $user->activity()->latest()->with('subject')->take(50)
                    ->get()
                    ->groupBy(function($activity){
                        return $activity->created_at->format('Y-m-d');
                    });
    }
}
