<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    public function test_a_user_has_a_profile()
    {
        $user = create('App\User');

        $this->get("/profiles/{$user->name}")
                ->assertSee($user->name);
    }

    public function test_a_profiles_display_all_threads_created_by_the_associated_user()
    {
        $this->signIn();

        $thread = create(self::ThreadTbl, ['user_id' => auth()->id()]);

        $this->get("/profiles/". auth()->user()->name)
                ->assertSee($thread->title)
                ->assertSee($thread->body);
    }
}
