<?php

use App\Equipment;
use Faker\Generator as Faker;

$factory->define(Equipment::class, function (Faker $faker) {
    return [
        'number'                => $faker->numberBetween(1, 99999),
        'brand'                 => $faker->word,
        'model'                 => $faker->word,
        'serial_number'         => $faker->ean8,
        'description'           => $faker->sentence(),
        'weight'                => $faker->numberBetween(10, 10000),
        'purchase_date'         => $faker->date('Ymd'),
        'purchase_value'        => $faker->numberBetween(101, 10000),
        'depreciation_amount'   => $faker->numberBetween(1, 100),
        'depreciation_note'     => $faker->sentence(),
        'use_of_equipment'      => $faker->sentence(),
        'status'                => 'active',
        'manual_url'            => "http://192.168.1.10/manuals",
        'manual_file_location'  => 'Manual Filing Cabinet',
        'procedures_location'   => 'Procedures Filing Cabinet',
        'schematics_location'   => 'Schematics Filing Cabinet',
        'service_by_days'       => $faker->numberBetween(10, 365),
        'account_asset_number'  => $faker->ean13,
        'size_x'                => $faker->numberBetween(1, 1000),
        'size_y'                => $faker->numberBetween(1, 1000),
        'size_z'                => $faker->numberBetween(1, 1000)
    ];
});
