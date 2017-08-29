<?php

namespace Tests\Unit;

use App\Book;
use App\UserReview;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCanGetAverageBookRating()
    {
        $book = factory(Book::class)->create();

        factory(UserReview::class)->create([
            'book_id' => $book->id,
            'rating' => 1
        ]);

        factory(UserReview::class)->create([
            'book_id' => $book->id,
            'rating' => 5
        ]);

        $this->assertEquals(3, $book->getAverageRating());
    }

    public function testItCanGetOnlyAvailableBooks()
    {
        $book1 = factory(Book::class)->create([
            'status' => 'available'
        ]);
        $book2 = factory(Book::class)->create([
            'status' => 'unavailable'
        ]);

        $availableBooks = Book::available()->get();

        $this->assertTrue($availableBooks->contains($book1));
        $this->assertFalse($availableBooks->contains($book2));
    }

    public function testItCanGetOnlyUnavailableBooks()
    {
        $book1 = factory(Book::class)->create([
            'status' => 'unavailable'
        ]);
        $book2 = factory(Book::class)->create([
            'status' => 'available'
        ]);

        $availableBooks = Book::unavailable()->get();

        $this->assertTrue($availableBooks->contains($book1));
        $this->assertFalse($availableBooks->contains($book2));
    }

    public function testItCanGetOnlyLostBooks()
    {
        $book1 = factory(Book::class)->create([
            'status' => 'lost'
        ]);
        $book2 = factory(Book::class)->create([
            'status' => 'available'
        ]);

        $availableBooks = Book::lost()->get();

        $this->assertTrue($availableBooks->contains($book1));
        $this->assertFalse($availableBooks->contains($book2));
    }

    public function testItCanGetOnlyRemovedBooks()
    {
        $book1 = factory(Book::class)->create([
            'status' => 'removed'
        ]);
        $book2 = factory(Book::class)->create([
            'status' => 'available'
        ]);

        $availableBooks = Book::removed()->get();

        $this->assertTrue($availableBooks->contains($book1));
        $this->assertFalse($availableBooks->contains($book2));
    }
}
