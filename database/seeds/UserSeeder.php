<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('Tester12')
        ]);

        $role = Role::where('slug', 'admin')->first();

        $user->roles()->attach($role->id);
        $user->save();

        factory(User::class, 50)->create();
    }
}
