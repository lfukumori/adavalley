<?php

use App\User;
use App\Equipment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Walt',
            'email' => 'walter@test.com',
            'password' => bcrypt('password')
        ]);

        factory(Equipment::class, 2)->create();
    }
}
