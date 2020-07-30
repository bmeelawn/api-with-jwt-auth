<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use App\Rating;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description' => $faker->text($maxNbChars = 200) 
    ];
});

$factory->define(Rating::class, function (Faker $faker) {
    return [
        'rating' => $faker->numberBetween(1,5)
    ];
});
