<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\TypicodeApi\TypicodeApiService;

#[AsCommand(
    name: 'app:pull-posts',
    description: 'Pobiera posty z API REST i zapisuje je do bazy wraz z imieniem i nazwiskiem autora'
)]
class PullPostsCommand extends Command
{

    public function __construct(
        protected readonly TypicodeApiService $api
    ) {
        parent::__construct();
    }
/*
    protected function configure(): void
    {
        $this
            ->addOption(
                'output',
                'o',
                InputOption::VALUE_REQUIRED,
                'Output path. If no given, an auto generated name will be chosen and saved in a current directory.'
            );
    }
*/
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
        foreach($posts as &$post){
            $user = $this->searchUser($users, $post['userId']);
            $post['author_name'] = $user['name'];
            $io->text([
                $post['title'],
                $post['author_name']
                ]);
        }
        return Command::SUCCESS;
    }
}
