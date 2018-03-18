<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Happy\ThreadMan\Activity;

class ProfilesController extends Controller
{

    public function show(User $user){

        return view('profiles.show', [
            'profileUser'       => $user,
            'activities'        => $this->getActivity($user),
        ]);
    }

    public function getActivity(User $user)
    {
        return $user->activity()->latest()->with('subject')->take(50)
                    ->get()
                    ->groupBy(function($activity){
                        return $activity->created_at->format('Y-m-d');
                    });
    }
}
