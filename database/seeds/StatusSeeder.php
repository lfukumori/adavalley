<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Active', 'Inactive', 'Stored'];

        foreach ($statuses as $status) {
            factory(Status::class)->create([
                "name" => $status
            ]);
        }
    }
}
