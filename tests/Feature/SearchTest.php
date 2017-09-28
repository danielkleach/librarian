<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testIndexEndpointCanSearchForBooks()
    {
        $book = factory(Book::class)->create([
            'title' => 'Title for Search',
            'description' => 'A good book.',
            'isbn' => '9999999999',
            'publication_year' => 2017
        ]);

        sleep(1);

        $data = ['search' => 2017];

        $response = $this->postJson("/search", $data);

        $response->assertStatus(200);
        $this->assertEquals($book->title, $response->json()[0]['title']);
        $book->delete();
    }
}
