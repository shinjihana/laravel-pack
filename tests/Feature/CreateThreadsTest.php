<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

use Happy\ThreadMan\Thread;
use Happy\ThreadMan\Recaptcha;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations, MockeryPHPUnitIntegration;

    public function setUp()
    {
        parent::setUp();
        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    function test_guest_may_not_create_thread()
    {
        /* Given we have a signed in User */
        // $this->actingAs(factory('App\User')->create());

        /* When we hit the endpoint to create a new thread */
        $this->withExceptionHandling();
        $this->get('/threads/create')
            ->assertRedirect(route('login'));
        $this->post(route('threads'))
            ->assertRedirect(route('login'));
    }

    function test_guest_cannot_see_the_create_thread_page()
    {
       $this->get('/threads/create')
                ->assertRedirect('/login'); 
    }

    public function test_new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();

        $this->signIn($user);

        $thread = make(self::ThreadTbl);

        $this->post(route('threads'), $thread->toArray())
                ->assertRedirect(route('threads'))
                ->assertSessionHas('flash', 'You must first confirm your email address.');
    }

    public function test_a_user_can_create_new_forum_threads()
    {
        /* Given we have a signed in User */
        // $this->actingAs(create('App\User'));
        // $this->signIn();

        // /* When we hit the endpoint to create a new thread */
        // $thread = create(self::ThreadTbl);
        // $response = $this->post('/threads', $thread->toArray());

        // /* Then, when we visit the thread page:*/
        // $response = $this->get($response->headers->get('Location'));

        // /* we should see the new thread:*/
        // $response->assertSee($thread->title)
        //         ->assertSee($thread->body);

        /**
         * New Version
         */
        $response = $this->publishThread(['title' => 'Some Title', 'body' => 'Some body.']);
        // $this->get($response->headers->get('Location'))
        //     ->assertSee('Some Title')
        //     ->assertSee('Some body.');
    }
    /** @test */
    function a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);
        $this->publishThread(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
                ->assertSessionHasErrors('title');
    }

    function test_a_thread_requires_a_channel()
    {
        $this->publishThread(['channel_id' => null])
                ->assertSessionHasErrors('channel_id');
    }

    public function test_a_thread_require_a_unique_slug()
    {
        $this->signIn();

        $thread = create(self::ThreadTbl, ['title' => 'Foo Title']);

        $this->assertEquals($thread->slug, 'foo-title');

        $thread = $this->postJson(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }

    public function test_a_thread_can_be_deleted()
    {
        $this->signIn();
        $thread = create(self::ThreadTbl, ['user_id' => auth()->id()]);
        $reply = create(self::ReplyTbl, ['thread_id' => $thread->id]);
        $response = $this->json('DELETE', $thread->path());
        // $response->assertStatus(204);
        // $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        // $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        // $this->assertEquals(0, Activity::count());
    }

    protected function publishThread($overrides = [])
    {
        $this->withExceptionHandling();
        $this->signIn();
        $thread = make(self::ThreadTbl, $overrides);
        
        return $this->post(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token']);
    }

    function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Some Title 24']);

        $thread = $this->postJson(route('threads'), $thread->toArray()  + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);
    }
}
