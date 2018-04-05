<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class LockThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_an_administrator_can_lock_any_thread()
    {
        $this->signIn(factory('App\User')->states('administrator')->create());

        $thread = create(self::ThreadTbl, ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread)); 

        $this->assertTrue($thread->fresh()->locked);
    }

    public function test_non_administrator_may_not_lock_threads()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create(self::ThreadTbl, ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(403);

        $this->assertFalse($thread->fresh()->locked);
    }
}
