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
        $book1 = factory(Book::class)->create();
        $book2 = factory(Book::class)->create();

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

        $availableBooks = Book::available()->get();

        $this->assertTrue($availableBooks->contains($book1));
        $this->assertFalse($availableBooks->contains($book2));
    }

    public function testItCanGetOnlyUnavailableBooks()
    {
        $book1 = factory(Book::class)->create();
        $book2 = factory(Book::class)->create();

        factory(Rental::class)->states(['withUser'])->create([
            'book_id' => $book1->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => null
        ]);

        factory(Rental::class)->states(['withUser'])->create([
            'book_id' => $book2->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => Carbon::createFromDate(2017, 01, 11)
        ]);

        $unavailableBooks = Book::unavailable()->get();

        $this->assertTrue($unavailableBooks->contains($book1));
        $this->assertFalse($unavailableBooks->contains($book2));
    }

    public function testItCanGetOnlyOverdueBooks()
    {
        $book1 = factory(Book::class)->create();
        $book2 = factory(Book::class)->create();

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
