<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Happy\ThreadMan\Thread;

class ThreadSubscriptionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }
}
