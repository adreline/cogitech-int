<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;

class PostsController extends AbstractController
{
    #[Route('/posts', name: 'app_posts')]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $posts = $doctrine->getRepository(Post::class)->findAll();
        $list = [];
        foreach($posts as $post){
            $list[]=[
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'user_id' => $post->getUserId(),
                'user_name' => $post->getAuthor(),
                'body' => $post->getBody()
            ];
        }
        return $this->json($list);
    }
}
