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

$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(env('STD_PASSWORD', str_random(10))),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Meetup::class, function ($faker) {
    $online = mt_rand(0, 100) > 50;
    return [
        'start_time' => $faker->dateTimeBetween('-6 months', '-1 week'),
        'online' => $online,
        'location_name' => $online ? null : $faker->company,
        'location_address' => $online ? null : $faker->address,
        'location_phone' => $online ? null : $faker->phoneNumber,
        'location_url' => $faker->url,
        'location_lat' => $online ? null : $faker->latitude(),
        'location_lng' => $online ? null : $faker->longitude(),
        'talk' => $faker->realText(75),
        'speaker' => $faker->name,
        'speaker_img' => $faker->imageUrl(60, 60, 'people'),
        'speaker_url' => $faker->url,
        'additional_info' => $faker->realText(200),
    ];
});

$factory->define(App\SlackInvite::class, function ($faker) {
    $created = $faker->dateTimeBetween('-14 days', '-3 days');
    return [
        'created_at' => $created,
        'updated_at' => $created,
        'name' => $faker->name,
        'email' => $faker->email,
        'token' => str_random(32),
        'confirmed_at' => $faker->optional()->dateTimeBetween('-2 days', 'now'),
    ];
});
