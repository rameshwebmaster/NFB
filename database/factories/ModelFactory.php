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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'gender' => $gender = $faker->boolean() + 1,
        'first_name' => $faker->firstName($gender == 1 ? 'male' : 'female'),
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'country' => $faker->countryCode,
        'birth_date' => $faker->dateTime('2000-01-01 00:00:00'),
        'remember_token' => str_random(10),
        'role' => 'consumer',
        'avatar' => $faker->randomElement(range(1,20)) . '.jpg',
        'language' => $faker->randomElement(['ar', 'en']),
    ];
});

$factory->define(App\Subscription::class, function (Faker\Generator $faker) {
    return [
        'type' => $faker->randomElement(['gold', 'platinum']),
        'status' => 'active',
        'start_date' => $start = $faker->dateTimeBetween('-1 year', 'now'),
        'expiry_date' => $faker->dateTimeBetween($start, '+2 years'),
    ];
});

$factory->define(App\HealthStatus::class, function (Faker\Generator $faker) {
    $diseases = ['1,1,0,0,0', '0,1,1,0,0', '0,1,0,0,0', '0,0,1,1,1', '0,0,1,1,0', '0,1,0,0,1', '0,1,1,1,0', '1,1,1,0,0', '1,0,1,0,1'];
    return [
        'weight' => $faker->randomFloat(2, 25, 150),
        'height' => $faker->numberBetween(30, 250),
        'shoulder_width' => $faker->randomFloat(2, 10, 100),
        'chest_circumference' => $faker->randomFloat(2, 10, 100),
        'middle_circumference' => $faker->randomFloat(2, 10, 100),
        'arm_circumference' => $faker->randomFloat(2, 10, 100),
        'hip_circumference' => $faker->randomFloat(2, 10, 100),
        'diseases' => $faker->randomElement($diseases),
    ];
});

$factory->define(App\Transaction::class, function (Faker\Generator $faker) {
    return [

    ];
});