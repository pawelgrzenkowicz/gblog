<?php

declare(strict_types=1);

namespace App\Application\Test\Reader;


use App\Application\Test\View\TestFullDataView;
use Ramsey\Uuid\UuidInterface;

interface TestFullDataReader
{
    /**
     * @return TestFullDataView[]
     */
    public function all(): array;

    /**
     */
    public function byUuid(UuidInterface $uuid): ?TestFullDataView;
}
