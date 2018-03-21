<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateForumTest extends TestCase
{
    use DatabaseMigrations;

    public $thread;

    public function setUp(){
        parent::setUp();

        $this->thread = factory(self::ThreadTbl)->create();
    }
    function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        //Give we have a authenticated user
        $user = factory('App\User')->create();
        $this->be($user); 
        //can be write like as $this->be($user = factory('App\User')->create();
        //And an Existing thread 
        $thread = factory(self::ThreadTbl)->create(['user_id' => $user->id]);
        //When the user adds a rely to thread
        $reply = factory(self::ReplyTbl)->create(['thread_id' => $thread->id, 'user_id' => $thread->user_id]);

        //check response return 200 if saving data is success
        $response =  $this->post($thread->path().'/replies', ['body' => $reply->body, '_token' => csrf_token()]);

        $this->assertDatabaseHas('replies', [
            'user_id' => $thread->user_id
        ]);
        $this->assertEquals(302, $response->getStatusCode());
        
        //Then their reply shoud be visible on the page
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

        $this->assertEquals(2, $thread->refresh()->replies_count);
    }

    function test_unauthenticated_users_may_not_add_replies(){
        
        $reply = factory(self::ReplyTbl)->create(['thread_id' => $this->thread->id]);

        $response =  $this->post($this->thread->path().'/replies', ['reply' => $reply->toArray(), '_token' => csrf_token()]);
        
        //302 -> have a redirect
        $this->assertEquals(302, $response->getStatusCode());
    }

    function test_unauthorized_users_cannot_delete_replies()
    {

        $reply = create(self::ReplyTbl);

        $this->delete("/replies/{$reply->id}")
                ->assertRedirect('login');

        $this->signIn()
             ->delete("/replies/{$reply->id}")
             ->assertStatus(403);
    }

    public function test_authorized_can_delete_replies()
    {
        $this->signIn();

        $reply = create(self::ReplyTbl, ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}");

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /**Test Update Reply */
    public function test_authirozied_user_can_update_reply()
    {
        $this->signIn();

        $reply = create(self::ReplyTbl, ['user_id' => auth()->id()]);

        $updateReplyContent = 'I have updated my reply';
        $this->patch("/replies/{$reply->id}", ['body' => $updateReplyContent]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updateReplyContent]);
    }

    function test_unauthorized_users_cannot_update_replies()
    {

        $reply = create(self::ReplyTbl);

        $this->patch("/replies/{$reply->id}")
                ->assertRedirect('login');

        $this->signIn()
             ->patch("/replies/{$reply->id}")
             ->assertStatus(403);
    }
}

