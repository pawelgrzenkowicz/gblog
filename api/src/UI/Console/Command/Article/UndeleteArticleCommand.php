<?php

declare(strict_types=1);

namespace App\UI\Console\Command\Article;

use App\Application\Article\Command\UndeleteArticle;
use Symfony\Component\Console\Attribute\AsCommand;
use App\Infrastructure\Symfony\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:undelete-article',
    description: 'Undelete article',
)]
class UndeleteArticleCommand extends Command
{
    protected function configure(): void
    {
//        php bin/console app:undelete-article -u3ce532e0-6a61-4593-a14e-72be025efd77

        $this
            ->setHelp('This command allow you to undelete article.')

            ->addOption('uuid', 'u', InputOption::VALUE_REQUIRED, 'uuid')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->application->execute(
            new UndeleteArticle(
                $input->getOptions()['uuid']
            )
        );

        $output->writeln([
            '<bg=green;>                       </>',
            '<bg=green;fg=black>  ARTICLE UNDELETED    </>',
            '<bg=green;>                       </>',
        ]);

        return Command::SUCCESS;
    }
}
