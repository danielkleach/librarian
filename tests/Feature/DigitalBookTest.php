<?php

namespace Tests\Feature;

use App\User;
use App\Category;
use Tests\TestCase;
use App\DigitalBook;
use App\Traits\MockABookLookup;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DigitalBookTest extends TestCase
{
    use MockABookLookup, DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedBook()
    {
        $book = factory(DigitalBook::class)->states(['withCategory'])->create();

        $response = $this->getJson("/digital-books/{$book->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => (int) $book->id,
            'category_id' => (int) $book->category_id,
            'title' => $book->title,
            'description' => $book->description,
            'isbn' => $book->isbn,
            'publication_year' => (int) $book->publication_year,
            'featured' => $book->featured,
            'download_count' => $book->download_count,
            'rating' => $book->rating
                ? number_format($book->rating, 1)
                : null,
            'cover_image_url' => $book->cover_image_url ?? null,
            'created_at' => $book->created_at->format('F j, Y'),
            'updated_at' => $book->updated_at->format('F j, Y')
        ]);
    }

    public function testStoreEndpointCreatesABookInTheDatabase()
    {
        $this->mockBookLookup();
        Storage::fake('media');

        $category = factory(Category::class)->create();
        $user = factory(User::class)->states(['admin'])->create();

        $data = [
            'category_id' => $category->id,
            'files[0]' => UploadedFile::fake()->create('book.pdf')
        ];

        $response = $this->actingAs($user)->postJson("/digital-books", $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('digital_books', [
            'category_id' => $category->id,
            'title' => 'New test title',
            'description' => 'New test description.',
            'isbn' => 'abcde12345',
            'publication_year' => 2017
        ]);
        $this->assertDatabaseHas('files', [
            'book_id' => $response->json()['data']['id'],
            'format' => 'pdf',
            'path' => 'media/' . $response->json()['data']['id'] . '-book.pdf'
        ]);
    }

    public function testUpdateEndpointUpdatesABookInTheDatabase()
    {
        $book = factory(DigitalBook::class)->states(['withCategory'])->create();
        $user = factory(User::class)->states(['admin'])->create();

        $data = [
            'title' => 'New test title',
            'description' => 'New test description.',
            'isbn' => 'abcde12345',
            'publication_year' => 2017
        ];

        $response = $this->actingAs($user)->patchJson("/digital-books/{$book->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('digital_books', $data);
    }
}
