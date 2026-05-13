<?php

namespace Database\Factory;

class CategoryFactory
{
    /** @return array<string, mixed> */
    public static function definition(\Faker\Generator $faker): array
    {
        $categories = [
            'Technology', 'Design', 'Travel', 'Food', 'Health',
            'Business', 'Science', 'Sports', 'Music', 'Art',
            'Education', 'Lifestyle', 'Finance', 'Nature', 'History',
        ];

        $name = $faker->unique()->randomElement($categories);
        $name = is_string($name) ? $name : '';

        return [
            'name' => $name,
            'slug' => strtolower($name),
            'description' => $faker->sentence(),
        ];
    }
}
