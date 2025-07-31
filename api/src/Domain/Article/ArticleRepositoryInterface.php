<?php

declare(strict_types=1);

namespace App\Domain\Article;

use App\Domain\Shared\ValueObject\String\SlugVO;
use Ramsey\Uuid\UuidInterface;

interface ArticleRepositoryInterface
{
    public function byUuid(UuidInterface $uuid): ?Article;

    public function bySlug(SlugVO $slug): ?Article;

    public function delete(Article $article): void;

    public function undelete(Article $article): void;

    public function uniqueUuid(): UuidInterface;

    public function save(Article $article): void;
}
