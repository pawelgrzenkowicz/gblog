<?php

declare(strict_types=1);

namespace App\Application\Test\Query\Handler;

use App\Application\Test\Query\GetSingleTest;
use App\Application\Test\Reader\TestFullDataReader;
use App\Application\Test\View\TestFullDataView;

readonly class GetSingleTestHandler
{
    public function __construct(
        private TestFullDataReader $reader
    ) {}

    public function __invoke(GetSingleTest $query): ?TestFullDataView
    {
        return $this->reader->byUuid($query->uuid);
    }
}
