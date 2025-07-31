<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\User;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\User\User;
use Doctrine\ODM\MongoDB\DocumentManager;

final readonly class JWTUserMongoRepository
{
    public function __construct(private DocumentManager $documentManager) {}

    public function byEmail(EmailVO $email): ?User
    {
        return $this->documentManager->createQueryBuilder(User::class)
            ->field('email')->equals($email)
            ->getQuery()
            ->getSingleResult();
    }
}
