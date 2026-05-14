<?php

namespace App\Controllers;

use App\Persistence\PostRepository;
use Core\View;

class PostController
{
    private PostRepository $postRepository;

    public function __construct()
    {
        $this->postRepository = new PostRepository();
    }

    public function __invoke(int $categoryId, int $postId): void
    {
        $post = $this->postRepository->getPost($postId);

        $similarPosts = $this->postRepository->getSimilar($categoryId, $postId);

        View::render('pages/post.tpl', ['post' => $post, 'similarPosts' => $similarPosts, 'categoryId' => $categoryId]);
    }
}
