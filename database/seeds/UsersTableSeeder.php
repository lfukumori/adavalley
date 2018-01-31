<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
            'email' => 'walter@adavalley.com',
            'password' => bcrypt('av1234'),
        ]);

        factory(User::class)->create([
            'name' => 'Brian',
            'email' => 'brian@adavalley.com',
            'password' => bcrypt('Maggot66'),
        ]);
    }
}
