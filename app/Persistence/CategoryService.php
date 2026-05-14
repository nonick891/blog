<?php

namespace App\Persistence;

readonly class CategoryService
{
    public function __construct(
        private CategoryRepository $repository = new CategoryRepository()
    ) {
    }

    /**
     * @param array{sort: string, order: string, page: int, perPage: int} $filters
     * @return array{
     *     category: array<string, string|null>|null,
     *     count: int,
     *     posts: array<int, array<string, string|null>>,
     * }
     */
    public function getCategoryData(int $id, array $filters): array
    {
        return [
            'category' => $this->repository->getCategory($id),
            'count' => $this->repository->countCategoryPosts($id),
            'posts' => $this->repository->getCategoryPosts($id, $filters),
        ];
    }
}
