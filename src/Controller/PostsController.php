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
        $post_repo = $doctrine->getRepository(Post::class);
        
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PostsController.php',
        ]);
    }
}
