<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    public function test_mentioned_users_in_a_reply_are_notified()
    {
        //Given I have a user, JohnDoe, who is signed in
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);

        //And another use, JaneDoe
        $jane = create('App\User', ['name' => 'JaneDoe']);
        $this->signIn($jane);

        //If we have a thread
        $thread = create(self::ThreadTbl);
        //And JohnDoe replies and mentions JaneDoe
        $reply  = make(self::ReplyTbl, [
            'body' => '@JaneDoe look at this.'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        //Then JaneDoe should be notified
        $this->assertCount(1, $jane->notifications);
    }
}
