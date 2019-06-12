<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(){
        parent::setUp();

        $this->prepareForTests();
    }

    public function prepareForTests(){
        Config::set('database.default', 'testing');
        Artisan::call('migrate');
    }
}
