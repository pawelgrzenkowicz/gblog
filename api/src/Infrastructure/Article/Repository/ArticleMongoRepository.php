<?php

declare(strict_types=1);

namespace App\Infrastructure\Article\Repository;

use App\Domain\Article\Article;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\DocumentManager;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final readonly class ArticleMongoRepository
{
    private const int MAX_RETRIES = 3;

    public function __construct(private DocumentManager $documentManager) {}

    public function byUuid(UuidInterface $uuid): ?Article
    {
        $result = $this->documentManager->createQueryBuilder(Article::class)
            ->field('uuid')->equals($uuid)
            ->getQuery()
            ->execute();

        return $result->toArray()[0] ?? null;
    }

    public function bySlug(SlugVO $slug): ?Article
    {
        $result = $this->documentManager->createQueryBuilder(Article::class)
            ->field('slug')->equals($slug)
            ->getQuery()
            ->execute();

        return $result->toArray()[0] ?? null;
    }

    public function delete(Article $article): void
    {
        $this->documentManager->createQueryBuilder(Article::class)
            ->findAndUpdate()
            ->field('uuid')->equals($article->uuid)
            ->field('removed')->set(true)
            ->getQuery()
            ->execute();
    }

    public function undelete(Article $article): void
    {
        $this->documentManager->createQueryBuilder(Article::class)
            ->findAndUpdate()
            ->field('uuid')->equals($article->uuid)
            ->field('removed')->set(false)
            ->getQuery()
            ->execute();
    }

    public function uniqueUuid(): UuidInterface
    {
        $retries = self::MAX_RETRIES;

        while ($retries-- > 0) {
            $uuid = Uuid::uuid4();

            $result = $this->documentManager->createQueryBuilder(Article::class)
                ->field('uuid')->equals($uuid)
                ->getQuery()
                ->execute();

            if (empty($result->toArray())) {
                return $uuid;
            }
        }

        throw new RuntimeException(Error::UNABLE_TO_GENERATE_UNIQUE_UUID->value);
    }

    public function save(Article $article): void
    {
        $this->documentManager->persist($article);
        $this->documentManager->flush();
    }
}
