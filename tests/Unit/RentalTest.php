<?php

namespace Tests\Unit;

use App\Book;
use App\User;
use App\Rental;
use Tests\TestCase;
use App\Exceptions\BookUnavailableException;
use App\Exceptions\BookAlreadyCheckedInException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RentalTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCannotCheckoutABookThatIsNotAvailable()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->states(['withCategory'])->create(['status' => 'unavailable']);

        $rental = new Rental();

        try {
            $rental->checkout($user, $book);
        } catch (BookUnavailableException $e) {
            $rental = $book->rentals()->where('user_id', $user->id)->first();
            $this->assertNull($rental);
            return;
        }

        $this->fail("Rental succeeded even though the book is unavailable.");
    }

    public function testItCannotCheckinABookThatIsAlreadyCheckedIn()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->states(['withCategory'])->create(['status' => 'available']);

        $rental = new Rental();

        try {
            $rental->checkin($book);
        } catch (BookAlreadyCheckedInException $e) {
            $rental = $book->rentals()->where('user_id', $user->id)->first();
            $this->assertNull($rental);
            return;
        }

        $this->fail("Rental checked in even though the book is already checked in.");
    }
}
