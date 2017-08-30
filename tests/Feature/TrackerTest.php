<?php

namespace Tests\Feature;

use App\User;
use App\Book;
use App\Tracker;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TrackerTest extends TestCase
{
    use DatabaseTransactions, WithoutMiddleware;

    public function testShowEndpointReturnsTheSpecifiedTracker()
    {
        $tracker = factory(Tracker::class)->create();

        $response = $this->getJson("/api/trackers/{$tracker->id}");

        $response->assertJsonFragment([
            'id' => (int) $tracker->id,
            'user_id' => (int) $tracker->user_id,
            'user_name' => $tracker->user->first_name,
            'book_id' => (int) $tracker->book_id,
            'book_title' => $tracker->book->title,
            'checkout_date' => $tracker->checkout_date->toDateTimeString(),
            'due_date' => $tracker->due_date->toDateTimeString(),
            'return_date' => $tracker->return_date
                ? $tracker->return_date->toDateTimeString()
                : null
        ]);
    }

    public function testStoreEndpointCreatesATrackerInTheDatabase()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create();

        $data = [
            'user_id' => (int) $user->id,
            'book_id' => (int) $book->id,
            'checkout_date' => Carbon::now()->subWeeks(2)->toDateTimeString(),
            'due_date' => Carbon::now()->toDateTimeString(),
            'return_date' => null
        ];

        $response = $this->postJson("/api/trackers", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('trackers', $data);
    }

    public function testUpdateEndpointUpdatesATrackerInTheDatabase()
    {
        $tracker = factory(Tracker::class)->create();

        $data = [
            'return_date' => Carbon::createFromFormat('Y-m-d H:i:s', $tracker->checkout_date)
                ->addDays(7)->toDateTimeString()
        ];

        $response = $this->patchJson("/api/trackers/{$tracker->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('trackers', $data);
    }

    public function testDestroyEndpointRemovesATracker()
    {
        $tracker = factory(Tracker::class)->create();

        $response = $this->deleteJson("/api/trackers/{$tracker->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('trackers', ['id' => $tracker->id, 'deleted_at' => null]);
    }
}
