<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_browse_thread()
    {
        $thread = factory('Happy\ThreadMan\Thread')->create();

        $response = $this->get('/threads');
        // $response->assertStatus(200);
        $response->assertSee($thread->title);
    }
}
