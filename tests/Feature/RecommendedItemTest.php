<?php

namespace Tests\Feature;

use App\Book;
use App\Ebook;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecommendedItemTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsTheBestRatedBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory'])->create(['rating' => 4.35]);
        $book2 = factory(Book::class)->states(['withCategory'])->create(['rating' => 4.22]);
        $book3 = factory(Book::class)->states(['withCategory'])->create(['rating' => 4.95]);

        $response = $this->getJson("/recommended/book");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book3->id, $responseData['data'][0]['id']);
        $this->assertEquals($book1->id, $responseData['data'][1]['id']);
        $this->assertEquals($book2->id, $responseData['data'][2]['id']);
    }

    public function testIndexEndpointReturnsTheBestRatedEbooks()
    {
        $book1 = factory(Ebook::class)->states(['withCategory'])->create(['rating' => 4.35]);
        $book2 = factory(Ebook::class)->states(['withCategory'])->create(['rating' => 4.22]);
        $book3 = factory(Ebook::class)->states(['withCategory'])->create(['rating' => 4.95]);

        $response = $this->getJson("/recommended/ebook");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book3->id, $responseData['data'][0]['id']);
        $this->assertEquals($book1->id, $responseData['data'][1]['id']);
        $this->assertEquals($book2->id, $responseData['data'][2]['id']);
    }

    public function testIndexEndpointReturnsTheBestRatedVideos()
    {
        $video1 = factory(Video::class)->create(['rating' => 4.35]);
        $video2 = factory(Video::class)->create(['rating' => 4.22]);
        $video3 = factory(Video::class)->create(['rating' => 4.95]);

        $response = $this->getJson("/recommended/video");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($video3->id, $responseData['data'][0]['id']);
        $this->assertEquals($video1->id, $responseData['data'][1]['id']);
        $this->assertEquals($video2->id, $responseData['data'][2]['id']);
    }
}
