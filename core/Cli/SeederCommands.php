<?php

namespace Core\Cli;

use Core\Database\DB;
use Database\Factory\CategoryFactory;
use Database\Factory\PostFactory;
use Faker\Factory;

class SeederCommands
{
    public static function truncate(): void
    {
        DB::query('SET FOREIGN_KEY_CHECKS = 0');
        DB::query('TRUNCATE TABLE post_category');
        DB::query('TRUNCATE TABLE posts');
        DB::query('TRUNCATE TABLE categories');
        DB::query('SET FOREIGN_KEY_CHECKS = 1');
    }

    public static function run(): void
    {
        self::truncate();

        $faker = Factory::create();

        $categoryData = [];
        for ($i = 0; $i < 10; $i++) {
            $categoryData[] = CategoryFactory::definition($faker);
        }
        DB::insertBatch('categories', $categoryData);

        $categories = DB::fetchAll('SELECT * FROM categories ORDER BY id');

        $postsAmount = 50;

        $postData = [];
        foreach ($categories as $category) {
            $categoryName = is_string($category['name']) ? $category['name'] : '';

            for ($j = 0; $j < $postsAmount; $j++) {
                $postData[] = PostFactory::definition($faker, $categoryName);
            }
        }
        DB::insertBatch('posts', $postData);

        $posts = DB::fetchAll('SELECT * FROM posts ORDER BY id');

        $linkData = [];
        foreach ($posts as $k => $post) {
            $categoryIndex = intdiv($k, $postsAmount);
            $linkData[] = [
                'post_id' => $post['id'],
                'category_id' => $categories[$categoryIndex]['id'],
            ];
        }
        DB::insertBatch('post_category', $linkData);

        echo "Seeding completed successfully\n";
    }
}
