<?php

use App\Rental;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Rental::class, 100)
            ->states(['withRandomUser', 'withRandomBook'])
            ->create();
    }
}
