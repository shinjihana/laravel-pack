<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class BestReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_thread_creatormay_mark_any_reply_as_the_best_reply()
    {
        $this->signIn();

        $thread = create(self::ThreadTbl, ['user_id' => auth()->id()]);

        $replies = create(self::ReplyTbl, ['thread_id' => $thread->id], 2);

        $this->postJson(route('best-replies.store', [$replies[1]->fresh()->id]));

        $this->assertTrue($replies[1]->fresh()->isBest());
    }

    public function test_only_thread_creator_may_mark_a_reply_as_best()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create(self::ThreadTbl, ['user_id' => auth()->id()]);

        $replies = create(self::ReplyTbl, ['thread_id' => $thread->id], 2);

        $this->signIn(create('App\User'));

        $this->postJson(route('best-replies.store', [$replies[1]->id]))->assertStatus(403);

        $this->assertFalse($replies[1]->fresh()->isBest());
    }

    function if_a_best_reply_is_deleted_then_the_thread_is_properly_updated_to_reflect_that()
    {
        $this->signIn();
        $reply = create(self::ReplyTbl, ['user_id' => auth()->id()]);
        $reply->thread->markBestReply($reply);
        $this->deleteJson(route('replies.destroy', $reply));
        $this->assertNull($reply->thread->fresh()->best_reply_id);
    }
}
