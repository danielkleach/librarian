<?php

use App\Download;
use Illuminate\Database\Seeder;

class DownloadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Download::class, 5000)
            ->states(['withRandomUser', 'withRandomBook'])
            ->create();
    }
}
