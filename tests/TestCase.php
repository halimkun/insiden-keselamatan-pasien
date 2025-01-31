<?php

namespace Tests;

use Artisan;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // seed database before running test
    use RefreshDatabase;

    // add this method
    public function setUp(): void
    {
        parent::setUp();

        // run migration
        Artisan::call('migrate:fresh');

        // run seeder
        Artisan::call('db:seed');
    }
}
