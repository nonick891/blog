<?php

namespace App\Persistence;

use Core\DB;

class CategoryService
{
    /**
     * @return array<string, mixed>|null
     */
    public function getCategory(int $categoryId): ?array
    {
        return DB::fetch("
            select c.id, c.name, c.description
            from categories as c
            where c.id = :id
        ", ['id' => $categoryId]);
    }

    public function countCategoryPosts(int $categoryId): int
    {
        $result = DB::fetch("
            select count(*) as count
            from posts as p
            left join post_category as pc on pc.post_id = p.id
            where pc.category_id = :category_id
        ", ['category_id' => $categoryId]);

        /** @var int $count */
        $count = $result['count'] ?? 0;

        return $count;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getCategoryPosts(int $categoryId, int $perPage, int $page): array
    {
        return DB::fetchAll(
            "
            select p.id, p.title, p.description,
                p.views, p.image, p.created_at
            from posts as p
            left join post_category as pc on pc.post_id = p.id
            where pc.category_id = :category_id
            order by p.created_at desc
            limit :per_page offset :offset
        ",
            ['category_id' => $categoryId, 'per_page' => $perPage, 'offset' => ($page - 1) * $perPage]
        );
    }
}
