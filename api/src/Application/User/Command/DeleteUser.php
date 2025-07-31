<?php

declare(strict_types=1);

namespace App\Application\User\Command;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly class DeleteUser
{
    public UuidInterface $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid);
    }
}
