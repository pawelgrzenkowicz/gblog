<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Repository;


use App\Domain\Test\Test;
use App\Domain\Test\TestRepositoryInterface;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\DocumentManager;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final readonly class TestMongoRepository
{
    private const int MAX_RETRIES = 3;

    public function __construct(private DocumentManager $documentManager) {}

    public function delete(Test $test): void
    {
        $this->documentManager->remove($test);
        $this->documentManager->flush();
    }

    public function byUuid(UuidInterface $uuid): ?Test
    {
        $qb = $this->documentManager->createQueryBuilder(Test::class)
            ->field('uuid')->equals($uuid)
            ->getQuery()
            ->execute();

        return empty($qb->toArray()) ? null : $qb->toArray()[0];
    }

    public function uniqueUuid(): UuidInterface
    {
        $retries = self::MAX_RETRIES;

        while ($retries-- > 0) {
            $uuid = Uuid::uuid4();

            $result = $this->documentManager->createQueryBuilder(Test::class)
                ->field('uuid')->equals($uuid)
                ->getQuery()
                ->execute();

            if (empty($result->toArray())) {
                return $uuid;
            }
        }

        throw new RuntimeException(Error::UNABLE_TO_GENERATE_UNIQUE_UUID->value);
    }

    public function save(Test $test): void
    {
        $this->documentManager->persist($test);
        $this->documentManager->flush();
    }
}
