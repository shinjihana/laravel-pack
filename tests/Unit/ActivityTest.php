<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Support\Carbon;
use Happy\ThreadMan\Activity;

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

    function test_it_fetches_a_feed_for_any_user()
    {
        //Given we have a thread
        $this->signIn();

        create(self::ThreadTbl, ['user_id' => auth()->id()], 2);
        //And another thread from a week ago

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        //when we fetch their feed 
        $feed = Activity::feed(auth()->user());

        // dd($feed->toArray());
        //then it should be returned in the proper format
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
        //then it should be returned in the proper format
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
