<?php

declare(strict_types=1);

namespace App\Application\Article\Command\Handler;

use App\Application\Article\Command\UpdateArticle;
use App\Application\Article\Exception\ArticleNotFoundException;
use App\Application\Article\Exception\ArticleSlugAlreadyExistException;
use App\Application\Picture\Exception\PictureSourceAlreadyExistException;
use App\Domain\Article\ArticleRepositoryInterface;
use App\Domain\Picture\PictureFileStorage;
use App\Domain\Picture\PictureFormatterInterface;
use App\Domain\Picture\PictureRepositoryInterface;
use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\String\PictureNameVO;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;

final readonly class UpdateArticleHandler
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
        private PictureRepositoryInterface $pictureRepository,
        private PictureFileStorage $fileStorage,
        private PictureFormatterInterface $formatter,
    ) {}

    public function __invoke(UpdateArticle $command): void
    {
        if (!$article = $this->articleRepository->byUuid($command->uuid)) {
            throw new ArticleNotFoundException();
        }

        if ($article->slug()->value !== $command->slug->value && $this->articleRepository->bySlug($command->slug)) {
            throw new ArticleSlugAlreadyExistException();
        }

        if ($file = $command->picture) {
            $extension = $file->guessExtension();
        } else {
            $file = $this->fileStorage->get($article->mainPicture());
            $extension = $file->getExtension();
        }

        $oldPicture = clone $article->mainPicture();
        $oldPictureSource = $oldPicture->source();

        $newSourceString = sprintf('%s.%s', $command->source->value, $extension);
        $newSource = new PictureSourceVO($newSourceString);

        if ($oldPictureSource->value !== $newSource->value && $this->pictureRepository->bySource($newSource)) {
            throw new PictureSourceAlreadyExistException();
        }

        $article->mainPicture()->update([
            'alt' => $command->alt,
            'source' => $newSource,
            'name' => new PictureNameVO($article->mainPicture()->pictureNameFormatter($newSource)),
            'extension' => PictureExtension::fromString($extension),
        ]);

        $article->update(
            [
                'contentHe' => $command->contentHe,
                'contentShe' => $command->contentShe,
                'readyHe' => $command->readyHe,
                'readyShe' => $command->readyShe,
                'slug' => $command->slug,
                'title' => $command->title,
                'categories' => $command->categories,
                'views' => $command->views,
                'removed' => $command->removed,
                'createDate' => $command->createDate,
                'publicationDate' => $command->publicationDate,

            ]
        );

        $this->articleRepository->save($article);

        $this->fileStorage->put($picture = $article->mainPicture(), $file);
        $this->formatter->run($picture);

        if ($oldPictureSource->value !== $newSource->value) {
            $this->formatter->remove($oldPictureSource->value);
            $this->fileStorage->delete($oldPicture);
        }
    }
}
