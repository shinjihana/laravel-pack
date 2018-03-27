<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Happy\ThreadMan\Thread;
use Happy\ThreadMan\Reply;

use Happy\ThreadMan\Rules\SpamFree;

class RepliesController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param   $channelId
     * @param Thread $thread
     * @param Spam $spam
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread)
    {
        if (\Gate::denies('create', new Reply)) {
            return response(
                'You are posting frequently, please take a break. :)', 422
            );
        }
        
        try {

            request()->validate(['body' => ['required', new SpamFree]]);

            $lastReply = Reply::where('user_id', auth()->id())->latest()->first();

            $reply = $thread->addReply([
                'body'          => request('body'),
                'user_id'       => auth()->id(),
            ]);
        } catch (\Exception $e) {
            return response('sorry fuk u', 422);
        }

        return $reply->load('owner');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
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
    public function update(Reply $reply)
    {
        try {
            $this->authorize('update', $reply);

            request()->validate(['body' => ['required', new SpamFree]]);

        } catch(\Exception $e) {
            return response('sorry fuk u', 422);
        }

        $reply->update(request(['body']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()){
            return response([
                'status'    => 'Reply was deleted'
            ]);
        }
        return back();
    }
}
