<?php

namespace Happy\ThreadMan\Commons;

use Illuminate\Support\Facades\Redis;

class Trending
{
    protected $rowLimitView = 5;
    /**
     * Fetch all trending threads
     * @return array
     */
    public function get()
    {
        return array_map('json_decode', Redis::zrevrange($this->cacheKey(), 0, $this->rowLimitView--));
    }

    /***
     * Push a new thread to the trending list.
     */
    public function push($thread)
    {
        Redis::zincrby($this->cacheKey(), 1, json_encode([
            'title' => $thread->title,
            'path'  => $thread->path(),
        ]));
    }

    /**
     * Get the cache key name
     */
    public function cacheKey()
    {
        return app()->environment('testing')
                ? 'testing_trending_threads'
                : 'trending_threads';
    }

    /**
     * Reset all trending threads
     */
    public function reset()
    {
        Redis::del($this->cacheKey());
    }
}