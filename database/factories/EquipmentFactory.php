<?php

use App\Equipment;
use Faker\Generator as Faker;

$factory->define(Equipment::class, function (Faker $faker) {
    return [
        'number' => $faker->numberBetween(1, 1000),
        'brand' => $faker->word,
        'model' => $faker->word,
        'serial_number' => $faker->ean8,
        'weight' => $faker->numberBetween(100, 10000),
        'description' => $faker->sentence(),
        'purchase_value' => $faker->numberBetween(10, 10000),
        'purchase_date' => $faker->date('Ymd'),
        'current_value' => $faker->numberBetween(10, 8000),
        'depreciated_value' => $faker->numberBetween(10, 1000),
        'depreciation_value' => $faker->numberBetween(1, 100),
        'depreciation_note' => $faker->sentence(),
        'use_of_equipment' => $faker->sentence(),
        'status' => 'in use',
        'location' => "Room {$faker->numberBetween(1, 4)}",
        'manual_url' => "http://192.168.1.10/manuals",
        'procedures_location' => $faker->word,
        'service_by_days' => $faker->numberBetween(10, 90),
        'manual_file_location' => 'some location',
        'schematics_location' => 'another location',
        'active' => true,
        'account_asset_number' => $faker->ean13
    ];
});
