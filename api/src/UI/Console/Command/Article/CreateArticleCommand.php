<?php

declare(strict_types=1);

namespace App\UI\Console\Command\Article;

use App\Application\Article\Command\CreateArticle;
use App\Application\Picture\Command\AddPicture;
use App\Infrastructure\Symfony\Console\Command;
use SplFileInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:create-article',
    description: 'Create new article',
)]
class CreateArticleCommand extends Command
{
    private const string CORE_FILE_PATH = __DIR__ . '/../../../../../public/core/';
    private const string CONTENT_DIR = __DIR__ . '/';
    private const string DEFAULT_MAIN_PICTURE_SOURCE = 'article/main/2020/';
    private const string TEMPORARY_FILE_PATH = __DIR__ . '/../../../../../public/temporary/';

    protected function configure(): void
    {
//        php bin/console app:create-article -cLorem.txt -cLorem.txt --mainPictureName=command-dragon-ball-db2.jpg --mainPictureAlt=Dragon_alt -r1 -r1 -scommand-1-slug_jakis_tam -tjakistytul --categories=rodzina,malzenstwo --views=0 --removed=0 --createDate=1994-06-30T17:40 --publicationDate=2004-06-30T17:40 --mainPictureFile=dragon-ball-db2.jpg



        $this
            ->setHelp('This command allow you to create article.')

            ->addOption('contents', 'c', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Content')
            ->addOption('mainPictureName', mode: InputOption::VALUE_REQUIRED, description: 'Main picture name')
            ->addOption('mainPictureAlt', mode: InputOption::VALUE_REQUIRED, description: 'Main picture alt')
            ->addOption('ready', 'r', InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Ready')
            ->addOption('slug', 's', InputOption::VALUE_REQUIRED, 'Slug')
            ->addOption('title', 't', InputOption::VALUE_REQUIRED, 'Title')
            ->addOption('categories', mode:InputOption::VALUE_REQUIRED, description: 'Categories')
            ->addOption('views', mode: InputOption::VALUE_REQUIRED, description: 'Views')
            ->addOption('removed', mode: InputOption::VALUE_REQUIRED, description: 'Removed')
            ->addOption('createDate', mode: InputOption::VALUE_REQUIRED, description: 'Create date')
            ->addOption('publicationDate', mode: InputArgument::OPTIONAL, description: 'Publication date')

            ->addOption('mainPictureFile', mode: InputOption::VALUE_REQUIRED, description: 'Main picture file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputData = $input->getOptions();

        $contentHe = file_get_contents(self::CONTENT_DIR . $inputData['contents'][0]);
        $contentShe = file_get_contents(self::CONTENT_DIR . $inputData['contents'][1]);

        $mainPictureAlt = $inputData['mainPictureAlt'];
        $readyHe = (bool) $inputData['ready'][0];
        $readyShe = (bool) $inputData['ready'][1];
        $slug = $inputData['slug'];
        $title = $inputData['title'];
        $categories = $inputData['categories'];
        $views = $inputData['views'];
        $removed = (bool) $inputData['removed'];
        $createDate = $inputData['createDate'];
        $publicationDate = $inputData['publicationDate'];

        $this->copyImage($inputData['mainPictureFile']);

        $mainPictureFile = new SplFileInfo(
            sprintf('%s%s', self::TEMPORARY_FILE_PATH, $inputData['mainPictureFile'])
        );

        $picture = $this->application->execute(new AddPicture(
            self::DEFAULT_MAIN_PICTURE_SOURCE . $inputData['mainPictureName'],
            $mainPictureAlt,
            $mainPictureFile->getExtension(),
            $mainPictureFile
        ));

        $output->writeln([
            '<bg=green;>                       </>',
            '<bg=green;fg=black>    PICTURE CREATED    </>',
            '<bg=green;>                       </>',
        ]);

        $this->application->execute(
            new CreateArticle(
                $picture,
                $contentHe,
                $contentShe,
                $readyHe,
                $readyShe,
                $slug,
                $title,
                $categories,
                (int) $views,
                $removed,
                $createDate,
                $publicationDate,
            )
        );

        $output->writeln([
            '<bg=green;>                       </>',
            '<bg=green;fg=black>    ARTICLE CREATED    </>',
            '<bg=green;>                       </>',
            ' '
        ]);

        return Command::SUCCESS;
    }

    private function copyImage(string $imageName): void
    {
        copy(
            sprintf('%s%s', self::CORE_FILE_PATH, $imageName),
            sprintf('%s%s', self::TEMPORARY_FILE_PATH, $imageName)
        );
    }
}
