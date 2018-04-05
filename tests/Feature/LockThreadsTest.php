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
        $this->signIn();

        $thread = create(self::ThreadTbl);

        $thread->lock();

        $this->post($thread->path() . '/replies', [
            'body'      => 'Foobar',
            'user_id'   => create('App\User')->id,
        ])->assertStatus(422);
    }
}
