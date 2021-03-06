<?php

namespace Happy\ThreadMan\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Happy\ThreadMan\Mail\PleaseConfirmYourEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailConfirmationRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event, $user)
    {
        Mail::to($user)->send(new PleaseConfirmYourEmail($user));

        return redirect($this->redirectPath());
    }
}
