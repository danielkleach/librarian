<?php

namespace Tests\Unit;

use App\Book;
use App\User;
use App\Rental;
use Carbon\Carbon;
use Tests\TestCase;
use App\Exceptions\ItemUnavailableException;
use App\Exceptions\ItemAlreadyCheckedInException;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RentalTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCannotCheckoutABookThatIsNotAvailable()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->states(['withCategory'])->create();

        factory(Rental::class)->states(['withUser'])->create([
            'rentable_id' => $book->id,
            'rentable_type' => get_class($book),
            'return_date' => null
        ]);

        $rental = new Rental();

        try {
            $rental->checkout($user, $book);
        } catch (ItemUnavailableException $e) {
            $rental = $book->rentals()->where('user_id', $user->id)->first();
            $this->assertNull($rental);
            return;
        }

        $this->fail("Rental succeeded even though the item is unavailable.");
    }

    public function testItCannotCheckinABookThatIsAlreadyCheckedIn()
    {
        $user = factory(User::class)->create();
        $user->api_token = $user->generateToken();

        $book = factory(Book::class)->states(['withCategory'])->create();

        $rental = factory(Rental::class)->states(['withUser'])->create([
            'rentable_id' => $book->id,
            'rentable_type' => get_class($book),
            'return_date' => Carbon::now()->toDateTimeString()
        ]);

        try {
            $rental->checkin($book);
        } catch (ItemAlreadyCheckedInException $e) {
            $rental = $book->rentals()->where('user_id', $user->id)->first();
            $this->assertNull($rental);
            return;
        }

        $this->fail("Rental checked in even though the item is already checked in.");
    }
}
