<?php

namespace App\Controllers;

use App\Persistence\CategoryService;
use Core\DB;
use Core\Request;
use Core\View;

class CategoryController
{
    private CategoryService $postService;

    public function __construct(public Request $request)
    {
        $this->postService = new CategoryService();
    }

    public function __invoke(int $id): void
    {
        $page = max(1, (int)$this->request->get('page', '1'));

        $perPage = max(1, min(100, (int)$this->request->get('per_page', '15')));

        $category = $this->postService->getCategory($id);

        $count = $this->postService->countCategoryPosts($id);

        $posts = $this->postService->getCategoryPosts($id, $perPage, $page);

        $totalPages = (int)ceil(($count / $perPage));

        View::render('category.tpl', [
            'category' => $category, 'posts' => $posts,
            'page' => $page, 'perPage' => $perPage,
            'totalPages' => $totalPages
        ]);
    }
}
