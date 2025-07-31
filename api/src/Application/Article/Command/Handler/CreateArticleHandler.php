<?php

declare(strict_types=1);

namespace App\Application\Article\Command\Handler;

use App\Application\Article\Command\CreateArticle;
use App\Application\Article\Exception\ArticleSlugAlreadyExistException;
use App\Domain\Article\Article;
use App\Domain\Article\ArticleRepositoryInterface;

final readonly class CreateArticleHandler
{
    public function __construct(
        private ArticleRepositoryInterface $articleRepository,
    ) {}

    public function __invoke(CreateArticle $command): string
    {
        if ($this->articleRepository->bySlug($command->slug)) {
            throw new ArticleSlugAlreadyExistException();
        }

        $article = new Article(
            $uuid = $this->articleRepository->uniqueUuid(),
            $command->picture,
            $command->contentHe,
            $command->contentShe,
            $command->readyHe,
            $command->readyShe,
            $command->slug,
            $command->title,
            $command->categories,
            $command->views,
            $command->removed,
            $command->createDate,
            $command->publicationDate
        );

        $this->articleRepository->save($article);

        return $uuid->toString();
    }
}
