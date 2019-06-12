<?php

namespace Tests\Feature;

use App\Book;
use App\Ebook;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PopularItemTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsTheMostPopularBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory'])->create(['total_rentals' => 5]);
        $book2 = factory(Book::class)->states(['withCategory'])->create(['total_rentals' => 10]);
        $book3 = factory(Book::class)->states(['withCategory'])->create(['total_rentals' => 6]);

        $response = $this->getJson("/popular/book");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book2->id, $responseData['data'][0]['id']);
        $this->assertEquals($book3->id, $responseData['data'][1]['id']);
        $this->assertEquals($book1->id, $responseData['data'][2]['id']);
    }

    public function testIndexEndpointReturnsTheMostPopularEbooks()
    {
        $book1 = factory(Ebook::class)->states(['withCategory'])->create(['download_count' => 5]);
        $book2 = factory(Ebook::class)->states(['withCategory'])->create(['download_count' => 10]);
        $book3 = factory(Ebook::class)->states(['withCategory'])->create(['download_count' => 6]);

        $response = $this->getJson("/popular/ebook");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book2->id, $responseData['data'][0]['id']);
        $this->assertEquals($book3->id, $responseData['data'][1]['id']);
        $this->assertEquals($book1->id, $responseData['data'][2]['id']);
    }

    public function testIndexEndpointReturnsTheMostPopularVideos()
    {
        $video1 = factory(Video::class)->create(['total_rentals' => 5]);
        $video2 = factory(Video::class)->create(['total_rentals' => 10]);
        $video3 = factory(Video::class)->create(['total_rentals' => 6]);

        $response = $this->getJson("/popular/video");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($video2->id, $responseData['data'][0]['id']);
        $this->assertEquals($video3->id, $responseData['data'][1]['id']);
        $this->assertEquals($video1->id, $responseData['data'][2]['id']);
    }
}
