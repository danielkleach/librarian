<?php

namespace Tests\Unit;

use App\User;
use App\Tracker;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    public function testItCanGetNumberOfBooksUserCurrentlyHasCheckedOut()
    {
        $user = factory(User::class)->create();

        factory(Tracker::class)->create([
            'user_id' => $user->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => null
        ]);

        factory(Tracker::class)->create([
            'user_id' => $user->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => Carbon::createFromDate(2017, 01, 11)
        ]);

        $this->assertEquals(1, $user->getCheckedOut());
    }

    public function testItCanGetNumberOfBooksUserCurrentlyHasOverdue()
    {
        $user = factory(User::class)->create();

        factory(Tracker::class)->create([
            'user_id' => $user->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => null
        ]);

        factory(Tracker::class)->create([
            'user_id' => $user->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => Carbon::createFromDate(2017, 01, 11)
        ]);

        $this->assertEquals(1, $user->getOverdue());
    }
}
