<?php

namespace App\Traits;

use App\BookLookup;
use App\Exceptions\BookLookupFailureException;

trait MockABookLookup
{
    public function mockBookLookup()
    {
        app()->bind(BookLookup::class, function ($app) {
            return app(MockLookup::class);
        });
    }

    public function mockBookLookupFailure()
    {
        app()->bind(BookLookup::class, function ($app) {
            return app(MockLookupFailure::class);
        });
    }
}

class MockLookup extends BookLookup
{
    public $response = [
        'title' => 'New test title',
        'description' => 'New test description.',
        'isbn' => 'abcde12345',
        'publication_year' => 2017,
        'authors' => [
            'author one',
            'author two'
        ]
    ];

    public function handle($data)
    {
        return $this->response;
    }
}

class MockLookupFailure extends BookLookup
{
    public function handle($data)
    {
        throw new BookLookupFailureException();
    }
}
