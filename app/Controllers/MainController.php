<?php

namespace App\Controllers;

use Core\DB;
use Core\View;

class MainController
{
    /**
     * @return void
     */
    public function __invoke(): void
    {
        $posts = DB::fetchAll("
            select ranked.id, ranked.title, ranked.category_id,
                ranked.description, ranked.views,
                ranked.image, ranked.created_at,
                c.name as category_name, c.description as category_description
            from (
              select p.*, pc.category_id,
                     row_number() over (partition by pc.category_id order by p.created_at desc) as rn
              from posts p
              left join post_category pc on pc.post_id = p.id
            ) ranked
            left join categories c on c.id = category_id
            where rn <= 3
            order by ranked.created_at desc
        ");

        /** @var array<int, array{id: int, name: string, description: string, posts: list<array<string, mixed>>}> $grouped */
        $grouped = [];
        foreach ($posts as $post) {
            $catId = is_numeric($post['category_id']) ? (int) $post['category_id'] : 0;
            if (!isset($grouped[$catId])) {
                $grouped[$catId] = [
                    'id' => $catId,
                    'name' => $post['category_name'],
                    'description' => $post['category_description'],
                    'posts' => [],
                ];
            }
            if (count($grouped[$catId]['posts']) < 3) {
                $grouped[$catId]['posts'][] = $post;
            }
        }

        View::render('home.tpl', ['categories' => $grouped]);
    }
}
