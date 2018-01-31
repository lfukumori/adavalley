<?php

use App\Department;
use Faker\Generator as Faker;

$factory->define(Department::class, function (Faker $faker) {
    return [
        "name" => "Room {$faker->numberBetween(1,6)}"
    ];
});
