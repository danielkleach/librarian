<?php

namespace Database\Seeds;

use App\Type;
use Illuminate\Database\Seeder;

class StatusTypesTableSeeder extends Seeder
{
    public function run()
    {
        Type::create([
            'name' => 'Available',
            'description' => 'This book is currently available for checkout.'
        ]);

        Type::create([
            'name' => 'Unavailable',
            'description' => 'This book is currently unavailable for checkout.'
        ]);

        Type::create([
            'name' => 'Lost',
            'description' => 'This book\'s location is currently unknown.'
        ]);

        Type::create([
            'name' => 'Removed',
            'description' => 'This book is no longer available for checkout.'
        ]);
    }
}
