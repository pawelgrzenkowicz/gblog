<?php

declare(strict_types=1);

namespace App\Application\Article\Command\Handler;

use App\Application\Article\Command\DeleteArticle;
use App\Application\Article\Exception\ArticleNotFoundException;
use App\Domain\Article\ArticleRepositoryInterface;

readonly class DeleteArticleHandler
{
    public function __construct(private ArticleRepositoryInterface $repository)
    {
    }

    public function __invoke(DeleteArticle $command): void
    {
        if (!$article = $this->repository->byUuid($command->uuid)) {
            throw new ArticleNotFoundException();
        }

        $this->repository->delete($article);
    }
}
