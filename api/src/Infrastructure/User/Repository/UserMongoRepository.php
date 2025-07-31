<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Repository;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\DocumentManager;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final readonly class UserMongoRepository
{
    private const int MAX_RETRIES = 3;

    public function __construct(private DocumentManager $documentManager) {}

    public function delete(User $user): void
    {
        $this->documentManager->createQueryBuilder(User::class)
            ->findAndUpdate()
            ->field('uuid')->equals($user->uuid)
            ->field('removed')->set(true)
            ->getQuery()
            ->execute();
    }

    public function byEmail(EmailVO $emailVO): ?User
    {
        $result = $this->documentManager->createQueryBuilder(User::class)
            ->field('email')->equals($emailVO)
            ->getQuery()
            ->execute();

        return $result->toArray()[0] ?? null;
    }

    public function byNickname(NicknameVO $nicknameVO): ?User
    {
        $result = $this->documentManager->createQueryBuilder(User::class)
            ->field('nickname')->equals($nicknameVO)
            ->getQuery()
            ->execute();

        return $result->toArray()[0] ?? null;
    }


    public function byUuid(UuidInterface $uuid): ?User
    {
        $result = $this->documentManager->createQueryBuilder(User::class)
            ->field('uuid')->equals($uuid)
            ->getQuery()
            ->execute();

        return $result->toArray()[0] ?? null;
    }

    public function uniqueUuid(): UuidInterface
    {
        $retries = self::MAX_RETRIES;

        while ($retries-- > 0) {
            $uuid = Uuid::uuid4();

            $picture = $this->documentManager->createQueryBuilder(User::class)
                ->field('uuid')->equals($uuid)
                ->getQuery()
                ->getSingleResult();

            if (null === $picture) {
                return $uuid;
            }
        }

        throw new RuntimeException(Error::UNABLE_TO_GENERATE_UNIQUE_UUID->value);
    }

    public function save(User $user): void
    {
        $this->documentManager->persist($user);
        $this->documentManager->flush();
    }
}
