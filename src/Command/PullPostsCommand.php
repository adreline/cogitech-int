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
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $response = $this->api->fetchPosts();
        $response->getData();
    }
}
