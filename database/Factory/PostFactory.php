<?php

namespace Database\Factory;

class PostFactory
{
    /** @return array<string, mixed> */
    public static function definition(\Faker\Generator $faker, string $category = ''): array
    {
        $title = $category
            ? ucfirst($category) . ': ' . rtrim($faker->realTextBetween(40, 80), '.')
            : rtrim($faker->realTextBetween(40, 80), '.');

        return [
            'title' => $title,
            'description' => $faker->realTextBetween(80, 160),
            'body' => implode("\n\n", array_map(fn() => $faker->realTextBetween(200, 400), range(1, 5))),
            'image' => 'https://picsum.photos/seed/' . $faker->uuid() . '/1200/600',
            'views' => $faker->numberBetween(0, 10000),
            'created_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s')
        ];
    }
}
