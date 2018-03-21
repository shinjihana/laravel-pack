<?php

namespace Happy\ThreadMan;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['creator', 'channel'];
    
    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('replyCount', function($builder){
        //     $builder->withCount('replies');
        // });

        static::deleting(function ($thread){
            $thread->replies->each->delete();
            // $thread->replies->each(function($reply){
            //     $reply->delete();
            // });
        });
    }

    public function path(){
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies(){
        return $this->hasMany(Reply::class)
                    ->withCount('favorites')
                    ->with('owner');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Add a reply to thread
     * 
     * @param : Reply
     */
    public function addReply($reply){
        return $this->replies()->create($reply);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class, 'channel_id');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
