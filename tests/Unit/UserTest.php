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

    public function testItCanGetTheFullNameForAUser()
    {
        $user = factory(User::class)->create();
        $fullName = $user->first_name . ' ' . $user->last_name;

        $this->assertEquals($fullName, $user->full_name);
    }

    public function testItCanGetBooksUserCurrentlyHasCheckedOut()
    {
        $user = factory(User::class)->create();

        $tracker1 = factory(Tracker::class)->states(['withBook'])->create([
            'user_id' => $user->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => null
        ]);

        $tracker2 = factory(Tracker::class)->states(['withBook'])->create([
            'user_id' => $user->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => Carbon::createFromDate(2017, 01, 11)
        ]);

        $this->assertTrue($user->getCheckedOut()->contains($tracker1));
        $this->assertFalse($user->getCheckedOut()->contains($tracker2));
    }

    public function testItCanGetBooksUserCurrentlyHasOverdue()
    {
        $user = factory(User::class)->create();

        $tracker1 = factory(Tracker::class)->states(['withBook'])->create([
            'user_id' => $user->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => null
        ]);

        $tracker2 = factory(Tracker::class)->states(['withBook'])->create([
            'user_id' => $user->id,
            'checkout_date' => Carbon::createFromDate(2017, 01, 01),
            'due_date' => Carbon::createFromDate(2017, 01, 15),
            'return_date' => Carbon::createFromDate(2017, 01, 11)
        ]);

        $this->assertTrue($user->getCheckedOut()->contains($tracker1));
        $this->assertFalse($user->getCheckedOut()->contains($tracker2));
    }
}
