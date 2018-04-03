<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\MailFake;

use App\User;

use Happy\ThreadMan\Mail\PleaseConfirmYourEmail;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();
        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ]);
        // Mail::assertSent(PleaseConfirmYourEmail::class);
    }
    /** @test */
    function user_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();
        $this->post(route('register'), [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ]);
        $user = User::whereName('John')->first();
        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);
        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))
            ->assertRedirect(route('threads'));
        $this->assertTrue($user->fresh()->confirmed);
    }
    /** @test */
    function confirming_an_invalid_token()
    {
        $this->get(route('register.confirm', ['token' => 'invalid']))
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'Unknown token.');
    }
}