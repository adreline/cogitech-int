<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\TypicodeApi\TypicodeApiService;
use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;

#[AsCommand(
    name: 'app:pull-posts',
    description: 'Pobiera posty z API REST i zapisuje je do bazy wraz z imieniem i nazwiskiem autora'
)]
class PullPostsCommand extends Command
{

    public function __construct(
        protected readonly TypicodeApiService $api,
        protected readonly ManagerRegistry $doctrine
    ) {
        parent::__construct();
    }
    
    private function searchUser(array $users, int $user_id): array
    {
        foreach($users as $user){
            if($user['id'] === $user_id) return $user;
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $posts = $this->api->fetchPosts();
        $users = $this->api->fetchUsers();

        $entityManager = $this->doctrine->getManager();

        foreach($posts as $shard){
            $user = $this->searchUser($users, $shard['userId']);

            $post = new Post();
            $post->setUserId($shard['userId']);
            $post->setTitle($shard['title']);
            $post->setAuthor($user['name']);
            $post->setBody($shard['body']);
            $post->setLegacyId($shard['id']);
            $entityManager->persist($post);
        }

        $entityManager->flush();

        return Command::SUCCESS;
    }
}
