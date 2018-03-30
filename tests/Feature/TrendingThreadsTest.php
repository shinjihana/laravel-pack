<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Redis;

use Happy\ThreadMan\Commons\Trending;

class TrendingThreadsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->trending = new Trending();

        $this->trending->reset();
    }

    public function test_it_increments_a_threads_score_each_time_it_is_read()
    {
        $this->assertEmpty($this->trending->get());

        $thread = create(self::ThreadTbl);

       $this->call('GET', $thread->path());

       $this->assertCount(1, $trending = $this->trending->get());
 
       $this->assertEquals($thread->title, $trending[0]->title);
    }
}
