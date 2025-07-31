<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture\Repository;

use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureRepositoryInterface;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use App\Infrastructure\Symfony\Error;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final readonly class PictureRepository implements PictureRepositoryInterface
{
    private const int MAX_RETRIES = 3;

    public function __construct(private EntityManagerInterface $manager) {}

    public function bySource(PictureSourceVO $source): ?Picture
    {
        $result = $this->manager->createQueryBuilder()
            ->from(Picture::class, 'p')
            ->select('p')
            ->where('p.source = :source')
            ->setParameter('source', $source)
            ->getQuery()
            ->getResult();

        if ([] !== $result && !$result[0] instanceof Picture) {
            throw new LogicException(Error::WRONG_INSTANCE->value);
        }

        return $result[0] ?? null;
    }

    public function delete(Picture $picture): void
    {
        $this->manager->remove($picture);
        $this->manager->flush();
    }

    public function uniqueUuid(): UuidInterface
    {
        $retries = self::MAX_RETRIES;

        while ($retries-- > 0) {
            $uuid = Uuid::uuid4();

            $result = $this->manager->createQueryBuilder()
                ->from(Picture::class, 'p')
                ->select('p')
                ->where('p.uuid = :uuid')
                ->setParameter('uuid', $uuid)
                ->getQuery()
                ->getResult();

            if (empty($result)) {
                return $uuid;
            }
        }

        throw new RuntimeException(Error::UNABLE_TO_GENERATE_UNIQUE_UUID->value);
    }

    public function save(Picture $picture): void
    {
        $this->manager->persist($picture);
        $this->manager->flush();
    }
}
