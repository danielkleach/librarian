<?php

namespace Tests\Feature;

use App\Book;
use App\Video;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        Config::set('scout.driver', 'elastic');
    }

    public function testIndexEndpointCanSearchForBooks()
    {
        $book = factory(Book::class)->states(['withCategory'])->create([
            'title' => 'Title for Search',
            'description' => 'A good book.',
            'isbn' => '9999999999',
            'publication_year' => 2200
        ]);
        $book->searchable();

        sleep(1);

        $data = ['search' => 2200];

        $response = $this->postJson("/books/search", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $book->id,
            'title' => $book->title,
            'description' => $book->description,
            'isbn' => $book->isbn,
            'publication_year' => (int) $book->publication_year,
        ]);
        $book->unsearchable();
    }

    public function testIndexEndpointCanSearchForVideos()
    {
        $video = factory(Video::class)->create([
            'title' => 'Title for Search',
            'description' => 'A good video.',
            'release_date' => '2017-01-01',
            'runtime' => 120
        ]);
        $video->searchable();

        sleep(1);

        $data = ['search' => 'A good video.'];

        $response = $this->postJson("/videos/search", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $video->id,
            'title' => $video->title,
            'description' => $video->description,
            'release_date' => $video->release_date,
            'runtime' => $video->runtime
        ]);
        $video->unsearchable();
    }
}
