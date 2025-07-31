<?php

declare(strict_types=1);

namespace App\Application\Test\Query;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class GetSingleTest
{
    public UuidInterface $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid);
    }
}
