<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{

    use DatabaseMigrations;

    public function test_it_records_activity_when_a_thread_is_created()
    {

        $this->signIn();

        $thread = create(self::ThreadTbl, ['user_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'type'          => 'created_thread',
            'user_id'       => auth()->id(),
            'subject_id'    => $thread->id,
            'subject_type'  => self::ThreadTbl,
        ]);

        $activity = \Happy\ThreadMan\Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function test_it_record_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create(self::ReplyTbl);

        $this->assertEquals(2, \Happy\ThreadMan\Activity::count());
    }
}
