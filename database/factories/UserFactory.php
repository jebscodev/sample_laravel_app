<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    $employee_id = '0085';
    $fname = 'arnie';
    $lname = 'abante';
    $username = 'admin';
    $password = bcrypt('test12345');
    $email = 'admin@test.com';

    return [
        /* Default fields */
        // 'name' => $faker->name,
        // 'email' => $faker->unique()->safeEmail,
        // 'email_verified_at' => now(),
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // 'remember_token' => Str::random(10),

        /* Custom fields */
        'employee_id' => $employee_id,
        'first_name' => $fname,
        'last_name' => $lname,
        'email_address' => $email,
        'username' => $username,
        'password' => $password,
        'user_lock_count' => 0,
        'user_is_blocked' => 0,
        'status' => 1,
        'role_id' => 1, // admin
        'created_by' => 1,
        'updated_by' => 1,
        'created_date' => now(),
        'updated_date' => now()
    ];
});
