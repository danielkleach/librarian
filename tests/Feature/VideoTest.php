<?php

namespace Tests\Feature;

use App\User;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class VideoTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedVideo()
    {
        $video = factory(Video::class)->create();

        $response = $this->getJson("/videos/{$video->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $video->id,
            'owner_id' => $video->owner_id
                ? (int) $video->owner_id
                : null,
            'title' => $video->title,
            'description' => $video->description,
            'release_date' => $video->release_date,
            'runtime' => (int) $video->runtime,
            'tags' => $video->tags,
            'thumbnail_path' => $video->thumbnail_path,
            'header_path' => $video->header_path,
            'location' => $video->location,
            'featured' => $video->featured,
            'total_rentals' => $video->total_rentals ?? null,
            'rating' => $video->rating
                ? number_format($video->rating, 1)
                : null,
            'created_at' => $video->created_at->format('F j, Y'),
            'updated_at' => $video->updated_at->format('F j, Y')
        ]);
    }

    public function testStoreEndpointCreatesAVideoInTheDatabase()
    {
        $user = factory(User::class)->states(['admin'])->create();

        $data = [
            'owner_id' => $user->id,
            'title' => 'New test title',
            'description' => 'New test description.',
            'release_date' => '2017-01-01',
            'runtime' => 120,
            'thumbnail_path' => 'http://google.com/images/thumbs/1.jpg',
            'header_path' => 'http://google.com/images/headers/1.jpg',
            'location' => 'Software office',
            'tags' => [
                'tag1',
                'tag2'
            ],
            'actors' => [
                'Actor One',
                'Actor Two'
            ]
        ];

        $response = $this->actingAs($user)->postJson("/videos", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('videos', [
            'title' => 'New test title',
            'description' => 'New test description.',
            'release_date' => '2017-01-01',
            'runtime' => 120,
            'thumbnail_path' => 'http://google.com/images/thumbs/1.jpg',
            'header_path' => 'http://google.com/images/headers/1.jpg',
        ]);
        $this->assertDatabaseHas('taggables', [
            'taggable_id' => $response->json()['data']['id'],
            'taggable_type' => 'App\Video'
        ]);
    }

    public function testUpdateEndpointUpdatesAVideoInTheDatabase()
    {
        $video = factory(Video::class)->create();
        $user = factory(User::class)->states(['admin'])->create();

        $data = [
            'title' => 'New test title',
            'description' => 'New test description.',
            'release_date' => '2017-02-01',
            'runtime' => 150,
        ];

        $response = $this->actingAs($user)->patchJson("/videos/{$video->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('videos', $data);
    }
}
