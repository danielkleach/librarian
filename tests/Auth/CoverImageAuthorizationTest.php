<?php

namespace Tests\Feature;

use App\Book;
use App\User;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CoverImageAuthorizationTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreRejectsAnUnauthorizedUser()
    {
        $book = factory(Book::class)->create();

        $data = [
            'cover_image' => UploadedFile::fake()->image('test.jpg', $width = 100, $height = 100)
        ];

        $response = $this->actingAs(factory(User::class)->create())
            ->postJson("/cover-image/book/{$book->id}", $data);

        $response->assertStatus(401);
    }
}
