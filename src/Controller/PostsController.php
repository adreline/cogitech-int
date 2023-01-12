<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/lista', name: 'app_posts_editor')]
    public function show_editor(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Post::class)->findAll();
        $list = [];
        foreach($posts as $post){
            $list[]=[
                'id' => $post->getId(),
                'legacy_id' => $post->getLegacyId(),
                'title' => $post->getTitle(),
                'user_id' => $post->getUserId(),
                'user_name' => $post->getAuthor(),
                'body' => $post->getBody()
            ];
        }
        return $this->render('editor.html.twig',['posts'=>$list]);
    }
    #[Route('/lista/{id}', name: 'app_posts_editor_delete')]
    public function editor_delete(int $id,ManagerRegistry $doctrine, Request $request): Response
    {
        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('delete_post_token', $submittedToken)) {
            $entityManager = $doctrine->getManager();
            $post = $doctrine->getRepository(Post::class)->find($id);
            if(!$post){
                $this->addFlash('warning', 'Post not found');
            }else{
                $entityManager->remove($post);
                $entityManager->flush();
                $this->addFlash('success', 'Post id = '.$id.' deleted');
            }
        }else{
            $this->addFlash('warning', 'Post was not deleted');
        }

            $referer = $request->headers->get('referer');
            return $this->redirect($referer);
    }
}
