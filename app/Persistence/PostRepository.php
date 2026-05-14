<?php

namespace App\Persistence;

use Core\DB;

class PostRepository
{
    /**
     * @return array<string, string|null>
     */
    public function getPost(int $postId): array
    {
        /** @var array<string, string|null> $result */
        $result = DB::fetch("
            select * from posts where id = :id
        ", ['id' => $postId]);

        return $result;
    }

    /**
     * @return array<int, array<string, string|null>>
     */
    public function getSimilar(int $categoryId, int $postId): array
    {
        /** @var array<int, array<string, string|null>> $result */
        $result = DB::fetchAll("
            select p.id, p.title, p.description, p.image, p.created_at, p.views
            from posts as p
            inner join post_category as pc on pc.post_id = p.id and pc.category_id = :categoryId
            where p.id <> :id
            order by RAND()
            limit 3
        ", ['id' => $postId, 'categoryId' => $categoryId]);

        return $result;
    }
}
