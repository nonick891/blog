<?php

use Faker\Factory;

/** @return array<string, mixed> */
function categoryFactory(): array
{
    $categories = [
        'Technology', 'Design', 'Travel', 'Food', 'Health',
        'Business', 'Science', 'Sports', 'Music', 'Art',
        'Education', 'Lifestyle', 'Finance', 'Nature', 'History',
    ];

    $faker = Factory::create();
    $name = $faker->unique()->randomElement($categories);

    return [
        'name' => $name,
        'slug' => strtolower($name),
    ];
}