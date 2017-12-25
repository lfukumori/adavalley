<?php

use App\Equipment;
use Faker\Generator as Faker;

$factory->define(Equipment::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'brand' => $faker->word,
        'model' => $faker->word,
        'serial_number' => $faker->ean8,
        'weight' => $faker->numberBetween(100, 10000),
        'description' => $faker->sentence(),
        'purchase_value' => $faker->numberBetween(10, 10000),
        'purchase_date' => $faker->date('Y-m-d'),
        'current_value' => $faker->numberBetween(10, 8000),
        'depreciated_value' => $faker->numberBetween(10, 1000),
        'depreciation_value' => $faker->numberBetween(10, 1000),
        'depreciation_note' => $faker->sentence(),
        'use_of_equipment' => $faker->sentence(),
        'status' => 'in use',
        'location' => "Room {$faker->numberBetween(1, 4)}",
        'manual_url' => "www.test.com/manuals.php",
        'procedures_location' => $faker->word,
        'date_stored' => null,
        'service_by_days' => $faker->numberBetween(10, 90),
        'manual_file_location' => null,
        'schematics_location' => null,
        'active' => true
    ];
});
