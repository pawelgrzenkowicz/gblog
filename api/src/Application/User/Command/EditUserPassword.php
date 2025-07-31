<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\Shared\ValueObject\String\PlainPasswordVO;

final readonly class EditUserPassword
{
    public PlainPasswordVO $oldPassword;

    public PlainPasswordVO $newPlainPassword;

    public function __construct(string $oldPassword, string $newPlainPassword)
    {
        $this->oldPassword = new PlainPasswordVO($oldPassword);
        $this->newPlainPassword = new PlainPasswordVO($newPlainPassword);
    }
}
