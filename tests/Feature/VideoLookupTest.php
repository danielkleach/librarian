<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Traits\MockAVideoLookup;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoLookupTest extends TestCase
{
    use MockAVideoLookup, DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointCreatesAVideoByISBNInTheDatabase()
    {
        $this->mockVideoLookup();

        $user = factory(User::class)->states(['admin'])->create();

        $data = [
            'id' => '11111'
        ];

        $response = $this->actingAs($user)->postJson("/videos/lookup/create", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('videos', [
            'title' => 'Video Title',
            'description' => 'Video description.',
            'release_date' => '2017-01-01',
            'runtime' => 120,
            'thumbnail_path' => 'https://google.com/img/thumbnail.png',
            'header_path' => 'https://google.com/img/header.png'
        ]);
    }
}
