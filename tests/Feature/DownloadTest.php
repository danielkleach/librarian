<?php

namespace Tests\Feature;

use App\File;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DownloadTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testStoreEndpointCreatesADownloadInTheDatabase()
    {
        $user = factory(User::class)->create();
        $file = factory(File::class)->states(['withBook'])->create([
            'format' => 'pdf',
            'path' => 'tests/files/test.pdf',
            'filename' => 'test.pdf'
        ]);

        $data = [
            'format' => 'pdf'
        ];

        $response = $this->actingAs($user)->postJson("/ebooks/{$file->book_id}/download", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('downloads', [
            'user_id' => $user->id,
            'book_id' => $file->book_id
        ]);
    }
}
