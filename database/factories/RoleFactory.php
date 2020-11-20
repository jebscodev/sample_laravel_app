<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => 'admin',
        'description' => 'Admin Account',
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
        'created_date' => now(),
        'updated_date' => now(),
    ];
});
