<?php

namespace App\Controllers;

use App\Persistence\CategoryService;
use Core\Request;
use Core\View;

class CategoryController
{
    private CategoryService $categoryService;

    public function __construct(public Request $request)
    {
        $this->categoryService = new CategoryService();
    }

    public function __invoke(int $id): void
    {
        $page = max(1, (int)$this->request->get('page', '1'));

        $perPage = max(1, min(100, (int)$this->request->get('per_page', '15')));

        $sort = $this->request->get('sort', 'created_at', ['created_at', 'views']);

        $order = $this->request->get('order', 'desc', ['asc', 'desc']);

        $filters = [
            'sort' => $sort,
            'order' => $order,
            'page' => $page,
            'perPage' => $perPage,
        ];

        $data = $this->categoryService->getCategoryData($id, $filters);

        $totalPages = (int)ceil(($data['count'] / $perPage));

        View::render('category.tpl', [
            'category' => $data['category'], 'posts' => $data['posts'],
            'page' => $page, 'perPage' => $perPage,
            'totalPages' => $totalPages, 'sort' => $sort,
            'order' => $order,
        ]);
    }
}
