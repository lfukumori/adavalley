<?php

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
        DB::table('users')->insert([
            'name' => 'Walt',
            'email' => 'walter@adavalley.com',
            'password' => bcrypt('av1234'),
        ]);

        DB::table('users')->insert([
            'name' => 'Brian',
            'email' => 'brian@adavalley.com',
            'password' => bcrypt('password'),
        ]);
    }
}
