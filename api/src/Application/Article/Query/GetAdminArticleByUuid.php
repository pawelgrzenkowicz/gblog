<?php

declare(strict_types=1);

namespace App\Application\Article\Query;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly class GetAdminArticleByUuid
{
    public UuidInterface $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = Uuid::fromString($uuid);
    }
}
