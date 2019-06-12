<?php

namespace Tests\Feature;

use App\Book;
use App\Ebook;
use App\Video;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FeaturedItemTest extends TestCase
{
    use WithoutMiddleware, DatabaseTransactions;

    public function testIndexEndpointReturnsOnlyFeaturedBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory'])->create(['featured' => true]);
        $book2 = factory(Book::class)->states(['withCategory'])->create(['featured' => false]);

        $response = $this->getJson("/featured/book");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $book1->id]);
        $response->assertJsonMissing(['id' => $book2->id]);
    }

    public function testIndexEndpointReturnsOnlyFeaturedEbooks()
    {
        $book1 = factory(Ebook::class)->states(['withCategory'])->create(['featured' => true]);
        $book2 = factory(Ebook::class)->states(['withCategory'])->create(['featured' => false]);

        $response = $this->getJson("/featured/ebook");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $book1->id]);
        $response->assertJsonMissing(['id' => $book2->id]);
    }

    public function testIndexEndpointReturnsOnlyFeaturedVideos()
    {
        $video1 = factory(Video::class)->create(['featured' => true]);
        $video2 = factory(Video::class)->create(['featured' => false]);

        $response = $this->getJson("/featured/video");

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $video1->id]);
        $response->assertJsonMissing(['id' => $video2->id]);
    }
}
