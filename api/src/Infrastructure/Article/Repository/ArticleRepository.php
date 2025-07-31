<?php

declare(strict_types=1);

namespace App\Infrastructure\Article\Repository;

use App\Domain\Article\Article;
use App\Domain\Article\ArticleRepositoryInterface;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Infrastructure\Symfony\Error;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final readonly class ArticleRepository implements ArticleRepositoryInterface
{
    private const int MAX_RETRIES = 3;

    public function __construct(private EntityManagerInterface $manager) {}

    public function byUuid(UuidInterface $uuid): ?Article
    {
        $result = $this->manager->createQueryBuilder()
            ->from(Article::class, 'a')
            ->leftJoin('a.mainPicture', 'p')
            ->select('a, p')
            ->where('a.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getResult();

        return $result[0] ?? null;
    }

    public function bySlug(SlugVO $slug): ?Article
    {
        $result = $this->manager->createQueryBuilder()
            ->from(Article::class, 'a')
            ->leftJoin('a.mainPicture', 'p')
            ->select('a, p')
            ->where('a.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getResult();

        return $result[0] ?? null;
    }

    public function delete(Article $article): void
    {
        $article->update(['removed' => true]);

        $this->manager->persist($article);
        $this->manager->flush();
    }

    public function undelete(Article $article): void
    {
        $article->update(['removed' => false]);

        $this->manager->persist($article);
        $this->manager->flush();
    }

    public function uniqueUuid(): UuidInterface
    {
        $retries = self::MAX_RETRIES;

        while ($retries-- > 0) {
            $uuid = Uuid::uuid4();

            $result = $this->manager->createQueryBuilder()
                ->from(Article::class, 'a')
                ->select('a')
                ->where('a.uuid = :uuid')
                ->setParameter('uuid', $uuid)
                ->getQuery()
                ->getResult();

            if (empty($result)) {
                return $uuid;
            }
        }

        throw new RuntimeException(Error::UNABLE_TO_GENERATE_UNIQUE_UUID->value);
    }

    public function save(Article $article): void
    {
        $this->manager->persist($article);
        $this->manager->flush();
    }
}
