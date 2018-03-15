<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Happy\ThreadMan\Reply;
use Happy\ThreadMan\Thread;
use Happy\ThreadMan\Favorite;

class FavoritesController extends Controller
{

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $threads = Thread::all();

        return $threads;
    }

    public function store(Reply $reply)
    {
        return $reply->favorite();
    }
}
