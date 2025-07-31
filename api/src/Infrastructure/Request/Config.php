<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

abstract class Config
{
    public function __construct(public string $route, public int $requestLimit, public string $timeFrame) {}
}
