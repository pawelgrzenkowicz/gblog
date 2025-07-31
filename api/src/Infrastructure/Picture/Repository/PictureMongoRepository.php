<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture\Repository;

use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureRepositoryInterface;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\DocumentManager;
use LogicException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final readonly class PictureMongoRepository
{
    private const int MAX_RETRIES = 3;

    public function __construct(private DocumentManager $documentManager) {}

    public function bySource(PictureSourceVO $source): ?Picture
    {
        $result = $this->documentManager->createQueryBuilder(Picture::class)
            ->field('picture.source')->equals($source->value)
            ->getQuery()
            ->getSingleResult();

        if (null !== $result && !$result instanceof Picture) {
            throw new LogicException(Error::WRONG_INSTANCE->value);
        }

        return $result;
    }

    public function delete(Picture $picture): void
    {
        $this->documentManager->remove($picture);
        $this->documentManager->flush();
    }

    public function uniqueUuid(): UuidInterface
    {
        $retries = self::MAX_RETRIES;

        while ($retries-- > 0) {
            $uuid = Uuid::uuid4();

            $picture = $this->documentManager->createQueryBuilder(Picture::class)
                ->field('uuid')->equals($uuid)
                ->getQuery()
                ->getSingleResult();

            if (null === $picture) {
                return $uuid;
            }
        }

        throw new RuntimeException(Error::UNABLE_TO_GENERATE_UNIQUE_UUID->value);
    }

    public function save(Picture $picture): void
    {
        $this->documentManager->persist($picture);
        $this->documentManager->flush();
    }
}
