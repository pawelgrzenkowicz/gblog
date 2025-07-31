<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\User;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\User\User;

interface JWTUserRepositoryInterface
{
    public function byEmail(EmailVO $email): ?User;
}
