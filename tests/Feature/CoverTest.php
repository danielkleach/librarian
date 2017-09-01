<?php

namespace Tests\Feature;

use App\Book;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoverImageTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointUploadsANewCoverImage()
    {
        $book = factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->create();

        $data = [
            'cover_image' => UploadedFile::fake()->image('test.jpg', $width = 100, $height = 100)
        ];

        $response = $this->postJson("/api/books/{$book->id}/cover-image", $data);

        $coverImage = $book->coverImage;
        $response->assertJsonFragment(['cover_image_url' => $coverImage->url()]);
        Storage::disk('media')->assertExists("{$coverImage->media->id}/test.jpg");
        Storage::disk('media')->deleteDirectory("{$coverImage->media->id}");
    }

    public function testStoreEndpointReplacesCoverImage()
    {
        $book = factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->create();
        $oldCoverImage = $book->coverImage->save(UploadedFile::fake()->image('old.jpg'));

        $data = [
            'cover_image' => UploadedFile::fake()->image('test.jpg', $width = 100, $height = 100)
        ];

        $response = $this->postJson("/api/books/{$book->id}/cover-image", $data);

        $coverImage = $book->fresh()->coverImage;
        $response->assertJsonFragment(['cover_image_url' => $coverImage->url()]);
        Storage::disk('media')->assertMissing("{$oldCoverImage->media->id}");
        Storage::disk('media')->assertExists("{$coverImage->media->id}/test.jpg");
        Storage::disk('media')->deleteDirectory("{$coverImage->media->id}");
    }

    public function testDestroyEndpointRemovesACoverImage()
    {
        $book = factory(Book::class)->states(['withCategory', 'withAuthor', 'withUser'])->create();
        $coverImage = $book->coverImage->save(UploadedFile::fake()->image('test.jpg'));

        $response = $this->deleteJson("/api/books/{$book->id}/cover-image");

        $response->assertStatus(204);
        Storage::disk('media')->assertMissing("{$coverImage->media->id}");
        $this->assertDatabaseMissing('media', ['id' => $coverImage->media->id]);
    }
}
