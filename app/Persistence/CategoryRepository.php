<?php

namespace App\Persistence;

use Core\Database\DB;

class CategoryRepository
{
    /**
     * @return array<string, string|null>|null
     */
    public function getCategory(int $categoryId): ?array
    {
        /** @var array<string, string|null> $result */
        $result = DB::fetch("
            select c.id, c.name, c.description
            from categories as c
            where c.id = :id
        ", ['id' => $categoryId]);

        return $result ?: null;
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
     * @param array{sort: string, order: string, page: int, perPage: int} $filters
     * @return array<int, array<string, string|null>>
     */
    public function getCategoryPosts(int $categoryId, array $filters): array
    {
        $orderBy = "order by p.{$filters['sort']} {$filters['order']}";

        /** @var array<int, array<string, string|null>> $result */
        $result = DB::fetchAll("
            select p.id, p.title, p.description,
                p.views, p.image, p.created_at
            from posts as p
            left join post_category as pc on pc.post_id = p.id
            where pc.category_id = :category_id
            $orderBy
            limit :per_page offset :offset
        ", [
            'category_id' => $categoryId,
            'per_page' => $filters['perPage'],
            'offset' => ($filters['page'] - 1) * $filters['perPage'],
        ]);

        return $result;
    }
}
