<?php

namespace App\Http\Controllers;

use Happy\ThreadMan\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Happy\ThreadMan\Rules\Recaptcha;
// use Illuminate\Support\Facades\Redis;

use Happy\ThreadMan\Channel;
use Happy\ThreadMan\Filters\ThreadFilters;
use Happy\ThreadMan\Rules\SpamFree;

use Happy\ThreadMan\Commons\Trending;

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
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads'   => $threads,
            'trending'  => $trending->get(),
        ]);
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
    public function store(Request $request, Recaptcha $recaptcha)
    {
        request()->validate([
            'title'         => 'required',
            'body'          => ['required', new SpamFree],
            'channel_id'    => 'required|exists:channels,id',
            'g-recaptcha-response' => ['required', $recaptcha]
        ]);

        $thread = Thread::create([
            'user_id'        => auth()->id(),
            'channel_id'     => request('channel_id'),
            'title'          => request('title'),
            'body'           => request('body'),
        ]);
        
        if (request()->wantsJson()) {
            return response($thread, 201);
        }

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
    public function show($channelId, Thread $thread, Trending $trending)
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
        /** =========Way 2 -ending ========= */

        $trending->push($thread);

        $thread->increment('visits');
        
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
    public function update($channel, Thread $thread)
    {

        $this->authorize('update', $thread);

        $thread->update(request()->validate([
            'title' => 'required',
            'body'  => 'required'
        ]));

        return $thread;
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
