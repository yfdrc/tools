<?php

use App\Models\Cangku;
use Faker\Generator as Faker;

$factory->define(Cangku ::class, function (Faker $faker)
{
    return [
        'name' => $faker->name,
        'address' => $faker->unique()->address,
        'gly' => $faker->unique()->text,
    ];
});
