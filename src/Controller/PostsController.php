<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends AbstractController
{
    #[Route('/posts', name: 'app_posts_api')]
    public function show_api(ManagerRegistry $doctrine): JsonResponse
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
    #[Route('/posts/edit', name: 'app_posts_editor')]
    public function show_editor(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Post::class)->findAll();
        return $this->render('editor.html.twig',['posts'=>$posts]);
    }
}
