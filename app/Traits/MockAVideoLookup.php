<?php

namespace App\Traits;

use App\VideoLookup;
use App\Exceptions\VideoLookupFailureException;

trait MockAVideoLookup
{
    public function mockVideoLookup()
    {
        app()->bind(VideoLookup::class, function ($app) {
            return app(MockVideoLookup::class);
        });
    }

    public function mockVideoLookupFailure()
    {
        app()->bind(VideoLookup::class, function ($app) {
            return app(MockVideoLookupFailure::class);
        });
    }
}

class MockVideoLookup extends VideoLookup
{
    public $response = [
        'title' => 'Video Title',
        'description' => 'Video description.',
        'release_date' => '2017-01-01',
        'runtime' => 120,
        'thumbnail_path' => 'https://google.com/img/thumbnail.png',
        'header_path' => 'https://google.com/img/header.png'
    ];

    public function get($data)
    {
        return $this->response;
    }
}

class MockVideoLookupFailure extends VideoLookup
{
    public function get($data)
    {
        throw new VideoLookupFailureException();
    }
}
