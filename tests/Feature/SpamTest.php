<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Happy\ThreadMan\Inspections\Spam;

class SpamTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();


    }
    public function test_it_checks_for_invalid_keywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));

    }

    public function test_checks_for_any_key_being_held_down()
    {

        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect("Hello world aaaaaa");
    }
}
