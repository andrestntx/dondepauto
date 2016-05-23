<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\Entities\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->safeEmail,
        'tel'   => $faker->phoneNumber,
        'role'  => $faker->randomElement(['admin', 'director', 'advertiser', 'publisher', 'adviser']),
        'password' => 'secret',
        'remember_token' => str_random(10),
    ];
});

$factory->defineAs(User::class, 'admin', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(User::class);
    return array_merge($user, ['role' => 'admin']);
});

$factory->defineAs(User::class, 'director', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw(User::class);
    return array_merge($user, ['role' => 'director']);
});

