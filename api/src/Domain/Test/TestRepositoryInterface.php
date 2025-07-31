<?php

declare(strict_types=1);

namespace App\Domain\Test;

use Ramsey\Uuid\UuidInterface;

interface TestRepositoryInterface
{
    public function delete(Test $test): void;

    public function byUuid(UuidInterface $uuid): ?Test;

    public function uniqueUuid(): UuidInterface;

    public function save(Test $test): void;
}
