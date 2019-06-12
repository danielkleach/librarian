<?php

namespace Tests\Feature;

use App\Book;
use App\Ebook;
use App\Video;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewItemTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsTheNewestBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory'])
            ->create(['created_at' => Carbon::now()->addDay()->toDateTimeString()]);

        $book2 = factory(Book::class)->states(['withCategory'])
            ->create(['created_at' => Carbon::now()->addDays(2)->toDateTimeString()]);

        $response = $this->getJson("/new/book");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book2->id, $responseData['data'][0]['id']);
        $this->assertEquals($book1->id, $responseData['data'][1]['id']);
    }

    public function testIndexEndpointReturnsTheNewestEbooks()
    {
        $book1 = factory(Ebook::class)->states(['withCategory'])
            ->create(['created_at' => Carbon::now()->addDay()->toDateTimeString()]);

        $book2 = factory(Ebook::class)->states(['withCategory'])
            ->create(['created_at' => Carbon::now()->addDays(2)->toDateTimeString()]);

        $response = $this->getJson("/new/ebook");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book2->id, $responseData['data'][0]['id']);
        $this->assertEquals($book1->id, $responseData['data'][1]['id']);
    }

    public function testIndexEndpointReturnsTheNewestVideos()
    {
        $video1 = factory(Video::class)->create(['created_at' => Carbon::now()->addDay()->toDateTimeString()]);

        $video2 = factory(Video::class)->create(['created_at' => Carbon::now()->addDays(2)->toDateTimeString()]);

        $response = $this->getJson("/new/video");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($video2->id, $responseData['data'][0]['id']);
        $this->assertEquals($video1->id, $responseData['data'][1]['id']);
    }
}
