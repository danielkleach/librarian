<?php

namespace Tests\Feature;

use App\Book;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NewBookTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointReturnsTheNewestBooks()
    {
        $book1 = factory(Book::class)->states(['withCategory'])
            ->create(['created_at' => Carbon::now()->addDay()->toDateTimeString()]);

        $book2 = factory(Book::class)->states(['withCategory'])
            ->create(['created_at' => Carbon::now()->addDays(2)->toDateTimeString()]);

        $response = $this->getJson("/new/books");

        $response->assertStatus(200);
        $responseData = $response->json();

        $this->assertEquals($book2->id, $responseData['data'][0]['id']);
        $this->assertEquals($book1->id, $responseData['data'][1]['id']);
    }
}
