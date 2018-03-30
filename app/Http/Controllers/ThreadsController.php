<?php

namespace App\Http\Controllers;

use Happy\ThreadMan\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Redis;

use Happy\ThreadMan\Channel;
use Happy\ThreadMan\Filters\ThreadFilters;
use Happy\ThreadMan\Rules\SpamFree;

class ThreadsController extends Controller
{
    /**
     * Create a new ThreadsController instance
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     * @Param Channel $channel
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        $trending = array_map('json_decode', Redis::zrevrange('trending_threads', 0, 4));

        return view('threads.index', compact('threads', 'trending'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title'         => 'required',
            'body'          => ['required', new SpamFree],
            'channel_id'    => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'user_id'        => auth()->id(),
            'channel_id'     => request('channel_id'),
            'title'          => request('title'),
            'body'           => request('body'),
        ]);
        
        return redirect($thread->path())
                ->with('flash', 'Your thread has been published!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Happy\ThreadMan\Channel  $channelId
     * @param  \Happy\ThreadMan\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId, Thread $thread)
    {
        // Record that the user visited this page

        // Compare that carbon instance with the $thread->updated_at
        
        /** =========Way 1========= */
        // $key = sprintf("users.%s.visit.%s", auth()->id(), $thread->id);

        // cache()->forever($key, Carbon::now());
        /** =========Way 1========= */

        /** =========Way 2 - using read(thread)========= */
        if (auth()->check()) {
            auth()->user()->read($thread);
        }
        /** =========Way 2========= */

        Redis::zincrby('trending_threads', 1, json_encode([
            'title' => $thread->title,
            'path'  => $thread->path(),
        ]));

        // return $thread;
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param Channel $channel
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
        //way 1
        // if ($thread->user_id != auth()->id()){
        //     if (request()->wantsJson()){
        //         return response(['status' => 'Permission Denied'], 403);
        //     }
        //     return redirect('/login');
        // }

        //way 2
        $this->authorize('update', $thread);

        $thread->delete();

        if( request()->wantsJson()){
            return response([], 204);
        }

        return back();
    }

    /**
     * @param Channel $channel
     * @param ThreadFilters $filters
     * 
     * @return Thread $thread
     */
    public function getThreads($channel, $filters){

        $threads = Thread::latest()->filter($filters);

        if ($channel->exists){
            $threads->where('channel_id', $channel->id);
        }

        return $threads->paginate(3);
    }
}
