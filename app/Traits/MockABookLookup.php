<?php

namespace App\Traits;

use App\Lookup;
use App\Exceptions\BookLookupFailureException;

trait MockABookLookup
{
    public function mockBookLookup()
    {
        app()->bind(Lookup::class, function ($app) {
            return app(MockLookup::class);
        });
    }

    public function mockBookLookupFailure()
    {
        app()->bind(Lookup::class, function ($app) {
            return app(MockLookupFailure::class);
        });
    }
}

class MockLookup extends Lookup
{
    public $response = [
        'title' => 'New test title',
        'description' => 'New test description.',
        'isbn' => 'abcde12345',
        'authors' => [
            'author one',
            'author two'
        ],
        'publication_year' => 2017
    ];

    public function handle($data)
    {
        return (object) $this->response;
    }
}

class MockLookupFailure extends Lookup
{
    public function handle($data)
    {
        throw new BookLookupFailureException();
    }
}
