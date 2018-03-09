<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use UserMan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $test = UserMan::getUser();

        return view('home', compact('test'));
    }
}
