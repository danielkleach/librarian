<?php

use App\FavoriteBook;
use Illuminate\Database\Seeder;

class FavoriteBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(FavoriteBook::class, 100)->states(['withRandomUser', 'withRandomBook'])->create();
    }
}
