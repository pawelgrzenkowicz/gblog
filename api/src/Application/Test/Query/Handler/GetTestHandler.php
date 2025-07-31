<?php

namespace App\Application\Test\Query\Handler;

use App\Application\Test\Query\GetTest;
use App\Application\Test\Reader\TestFullDataReader;

readonly class GetTestHandler
{
    public function __construct(
        private TestFullDataReader $reader
    ) {}

    public function __invoke(GetTest $query): array
    {
        return $this->reader->all();
    }
}
