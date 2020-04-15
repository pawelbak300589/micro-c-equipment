<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker)
{
    return [
        'website_id' => \App\Website::all()->first()->id,
        'name' => $faker->company,
        'url' => $faker->url,
    ];
});
