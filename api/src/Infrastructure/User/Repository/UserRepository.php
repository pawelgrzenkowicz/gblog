<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Repository;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Symfony\Error;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use RuntimeException;

final readonly class UserRepository implements UserRepositoryInterface
{
    private const int MAX_RETRIES = 3;

    public function __construct(private EntityManagerInterface $manager) {}

    public function delete(User $user): void
    {
        $user->update(['removed' => true]);

        $this->manager->persist($user);
        $this->manager->flush();
    }

    public function byEmail(EmailVO $emailVO): ?User
    {
        $result = $this->manager->createQueryBuilder()
            ->from(User::class, 'u')
            ->select('u')
            ->where('u.email = :email')
            ->setParameter('email', $emailVO)
            ->getQuery()
            ->getResult();

        return $result[0] ?? null;
    }

    public function byNickname(NicknameVO $nicknameVO): ?User
    {
        $result = $this->manager->createQueryBuilder()
            ->from(User::class, 'u')
            ->select('u')
            ->where('u.nickname = :nickname')
            ->setParameter('nickname', $nicknameVO)
            ->getQuery()
            ->getResult();

        return $result[0] ?? null;
    }


    public function byUuid(UuidInterface $uuid): ?User
    {
        $result = $this->manager->createQueryBuilder()
            ->from(User::class, 'u')
            ->select('u')
            ->where('u.uuid = :uuid')
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
                ->from(User::class, 'u')
                ->select('u')
                ->where('u.uuid = :uuid')
                ->setParameter('uuid', $uuid)
                ->getQuery()
                ->getResult();

            if (empty($result)) {
                return $uuid;
            }
        }

        throw new RuntimeException(Error::UNABLE_TO_GENERATE_UNIQUE_UUID->value);
    }

    public function save(User $user): void
    {
        $this->manager->persist($user);
        $this->manager->flush();
    }
}
