<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class NotificationsTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();

    }

    function test_a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_not_by_current_user()
    {
        $thread = create(self::ThreadTbl)->subscribe();

        //Then, each time a new reply is left
        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id'   => auth()->id(),
            'body'      => 'some reply here'
        ]);

        // A notification should be prepared for the user
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id'   => create('App\User')->id,
            'body'      => 'some reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    public function test_a_user_can_mark_a_notification_as_read()
    {
        create(\Illuminate\Notifications\DatabaseNotification::class);

        $user = auth()->user();

        tap(auth()->user(), function($user){
            $this->assertCount(1, $user->refresh()->unreadNotifications);
    
            $this->delete("/profiles/". $user->name. "/notifications/".  $user->unreadNotifications->first()->id);
    
            $this->assertCount(0, $user->fresh()->unreadNotifications);
    
        });
    }

    function test_a_user_can_fetch_their_unread_notifications()
    {
        create(\Illuminate\Notifications\DatabaseNotification::class);

        $user = auth()->user();

        $response = $this->getJson("/profiles/". $user->name. "/notifications")->json();

        $this->assertCount(1, $response);
    }

}
