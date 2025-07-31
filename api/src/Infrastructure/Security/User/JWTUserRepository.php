<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\User;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;

final readonly class JWTUserRepository implements JWTUserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $manager) {}

    public function byEmail(EmailVO $email): ?User
    {
        $result = $this->manager->createQueryBuilder()
            ->from(User::class, 'u')
            ->select('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getResult();

        return $result[0] ?? null;
    }
}
