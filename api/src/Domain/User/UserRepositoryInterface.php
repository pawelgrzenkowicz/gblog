<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use Ramsey\Uuid\UuidInterface;

interface UserRepositoryInterface
{
    public function byEmail(EmailVO $emailVO): ?User;
    
    public function byNickname(NicknameVO $nicknameVO): ?User;

    public function byUuid(UuidInterface $uuid): ?User;

    public function delete(User $user): void;

    public function uniqueUuid(): UuidInterface;

    public function save(User $user): void;
}
