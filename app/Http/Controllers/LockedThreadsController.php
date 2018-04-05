<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Happy\ThreadMan\Thread;

class LockedThreadsController extends Controller
{
    /**
     * Lock the given $thread
     * 
     * @param \Happy\ThreadMan\Thread $thread
     */
    public function store(Thread $thread)
    {
        $thread->update([
            'locked' => true
        ]);
    }

    /**
     * Unlock the given thread
    */
    public function destroy()
    {
        $thread->update([
            'locked'    => false
        ]);
    }
}
