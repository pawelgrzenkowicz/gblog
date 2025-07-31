<?php

declare(strict_types=1);

namespace App\UI\Console\Command\Tool;

use App\Application\Article\Command\CreateArticle;
use App\Application\Article\Query\GetAdminArticlesMongo;
use App\Application\Article\View\AdminArticleDetailsView;
use App\Application\Picture\Command\AddPicture;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Infrastructure\Symfony\Console\Command;
use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:tool-migrate-articles',
    description: 'Migrate articles from mongo to SQL database.'
)]
final class MigrateDataCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $articlesMongo = $this->application->ask(
            new GetAdminArticlesMongo(
                new Pagination(1, 100),
                new Sort('publicationDate', 'desc')
            ),
        );


        /** @var AdminArticleDetailsView $viewMongo */
        foreach ($articlesMongo['items'] as $key => $viewMongo) {


            $storageDir = __DIR__ . '/../../../../../images/storage/';

            $file = new SplFileInfo(
                $storageDir .
                $viewMongo->mainPicture['source']
            );

            $output->writeln([
                '<bg=white;>                     </>',
                sprintf('<bg=white;fg=black>       %s START       </>', $key),
                '<bg=white;>                     </>',
                ' '
            ]);

            $picture = $this->application->execute(
                new AddPicture(
                    $viewMongo->mainPicture['source'],
                    $viewMongo->mainPicture['alt'],
                    $viewMongo->mainPicture['extension'],
                    $file
                )
            );

            $output->writeln([
                '<bg=cyan;>                     </>',
                '<bg=cyan;fg=black>   PICTURE CREATED   </>',
                '<bg=cyan;>                     </>',
                ' '
            ]);

            $this->application->execute(
                new CreateArticle(
                    $picture,
                    $viewMongo->contents['he'],
                    $viewMongo->contents['she'],
                    $viewMongo->ready['he'],
                    $viewMongo->ready['she'],
                    $viewMongo->slug,
                    $viewMongo->title,
                    $viewMongo->categories,
                    $viewMongo->views,
                    $viewMongo->removed,
                    $viewMongo->createDate,
                    $viewMongo->publicationDate
                )
            );

            $output->writeln([
                '<bg=cyan;>                     </>',
                '<bg=cyan;fg=black>   ARTICLE CREATED   </>',
                '<bg=cyan;>                     </>',
                ' '
            ]);

            $output->writeln([
                '<bg=green;>                    </>',
                sprintf('<bg=green;fg=black>       %s DONE       </>', $key),
                '<bg=green;>                    </>',
                ' '
            ]);
        }

        return Command::SUCCESS;
    }
}
