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
        $book = factory(Book::class)->states(['withCategory'])->create();

        $data = [
            'cover_image' => UploadedFile::fake()->image('test.jpg', $width = 100, $height = 100)
        ];

        $response = $this->postJson("/cover-image/book/{$book->id}", $data);

        $response->assertStatus(201);

        $coverImage = $book->coverImage;
        $response->assertJsonFragment(['cover_image_url' => $coverImage->url()]);
        Storage::disk('media')->assertExists("{$coverImage->media->id}/test.jpg");
        Storage::disk('media')->deleteDirectory("{$coverImage->media->id}");
    }

    public function testStoreEndpointReplacesCoverImage()
    {
        $book = factory(Book::class)->states(['withCategory'])->create();
        $oldCoverImage = $book->coverImage->save(UploadedFile::fake()->image('old.jpg'));

        $data = [
            'cover_image' => UploadedFile::fake()->image('test.jpg', $width = 100, $height = 100)
        ];

        $response = $this->postJson("/cover-image/book/{$book->id}", $data);

        $response->assertStatus(201);

        $coverImage = $book->fresh()->coverImage;
        $response->assertJsonFragment(['cover_image_url' => $coverImage->url()]);
        Storage::disk('media')->assertMissing("{$oldCoverImage->media->id}");
        Storage::disk('media')->assertExists("{$coverImage->media->id}/test.jpg");
        Storage::disk('media')->deleteDirectory("{$coverImage->media->id}");
    }

    public function testDestroyEndpointRemovesACoverImage()
    {
        $book = factory(Book::class)->states(['withCategory'])->create();
        $coverImage = $book->coverImage->save(UploadedFile::fake()->image('test.jpg'));

        $response = $this->deleteJson("/cover-image/book/{$book->id}");

        $response->assertStatus(200);
        Storage::disk('media')->assertMissing("{$coverImage->media->id}");
        $this->assertDatabaseMissing('media', ['id' => $coverImage->media->id]);
    }
}
