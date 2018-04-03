<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

use Happy\ThreadMan\Mail\PleaseConfirmYourEmail;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();

        event(new Registered(create('App\User')));

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }
}
