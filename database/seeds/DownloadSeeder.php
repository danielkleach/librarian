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
        factory(Download::class, 500)
            ->states(['withRandomUser', 'withRandomBook'])
            ->create();
    }
}
