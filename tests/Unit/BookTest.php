<?php

namespace Tests\Unit;

use App\Book;
use App\Rental;
use Carbon\Carbon;
use App\UserReview;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BookTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCanGetOnlyAvailableBooks()
    {
        $book1 = factory(Book::class)->create(['status' => 'available']);
        $book2 = factory(Book::class)->create(['status' => 'unavailable']);

        $availableBooks = Book::available()->get();

        $this->assertTrue($availableBooks->contains($book1));
        $this->assertFalse($availableBooks->contains($book2));
    }

    public function testItCanGetOnlyUnavailableBooks()
    {
        $book1 = factory(Book::class)->create(['status' => 'unavailable']);
        $book2 = factory(Book::class)->create(['status' => 'available']);

        $unavailableBooks = Book::unavailable()->get();

        $this->assertTrue($unavailableBooks->contains($book1));
        $this->assertFalse($unavailableBooks->contains($book2));
    }

    public function testItCanGetOnlyLostBooks()
    {
        $book1 = factory(Book::class)->create(['status' => 'lost']);
        $book2 = factory(Book::class)->create(['status' => 'available']);

        $lostBooks = Book::lost()->get();

        $this->assertTrue($lostBooks->contains($book1));
        $this->assertFalse($lostBooks->contains($book2));
    }

    public function testItCanGetOnlyRemovedBooks()
    {
        $book1 = factory(Book::class)->create(['status' => 'removed']);
        $book2 = factory(Book::class)->create(['status' => 'available']);

        $removedBooks = Book::removed()->get();

        $this->assertTrue($removedBooks->contains($book1));
        $this->assertFalse($removedBooks->contains($book2));
    }

    public function testItCanGetOnlyOverdueBooks()
    {
        $book1 = factory(Book::class)->create(['status' => 'available']);
        $book2 = factory(Book::class)->create(['status' => 'unavailable']);

        factory(Rental::class)->states(['withUser'])->create([
            'book_id' => $book1->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => Carbon::createFromDate(2017, 01, 11)
        ]);

        factory(Rental::class)->states(['withUser'])->create([
            'book_id' => $book2->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => null
        ]);

        $overdueBooks = Book::overdue()->get();

        $this->assertTrue($overdueBooks->contains($book2));
        $this->assertFalse($overdueBooks->contains($book1));
    }

    public function testItCanGetOnlyFeaturedBooks()
    {
        $book1 = factory(Book::class)->create(['featured' => true]);
        $book2 = factory(Book::class)->create(['featured' => false]);

        $removedBooks = Book::featured()->get();

        $this->assertTrue($removedBooks->contains($book1));
        $this->assertFalse($removedBooks->contains($book2));
    }
}
