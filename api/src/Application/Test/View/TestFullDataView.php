<?php

declare(strict_types=1);

namespace App\Application\Test\View;

final readonly class TestFullDataView
{
    public function __construct(
        public string $uuid,
        public string $name,
        public int $number,
    ) {}
}
