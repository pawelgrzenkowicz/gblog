<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Repository;

use App\Domain\Test\Test;
use App\Domain\Test\TestRepositoryInterface;
use App\Infrastructure\Symfony\Error;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final readonly class TestRepository implements TestRepositoryInterface
{
    private const int MAX_RETRIES = 3;

    public function __construct(private EntityManagerInterface $manager) {}

    public function delete(Test $test): void
    {
        $this->manager->remove($test);
        $this->manager->flush();
    }

    public function byUuid(UuidInterface $uuid): ?Test
    {
        $result = $this->manager->createQueryBuilder()
            ->from(Test::class, 't')
            ->select('t')
            ->where('t.uuid = :uuid')
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getResult();

        return $result[0] ?? null;
    }

    public function uniqueUuid(): UuidInterface
    {
        $retries = self::MAX_RETRIES;

        while ($retries-- > 0) {
            $uuid = Uuid::uuid4();

            $result = $this->manager->createQueryBuilder()
                ->from(Test::class, 't')
                ->select('t')
                ->where('t.uuid = :uuid')
                ->setParameter('uuid', $uuid)
                ->getQuery()
                ->getResult();

            if (empty($result)) {
                return $uuid;
            }
        }

        throw new RuntimeException(Error::UNABLE_TO_GENERATE_UNIQUE_UUID->value);
    }

    public function save(Test $test): void
    {
        $this->manager->persist($test);
        $this->manager->flush();
    }
}
