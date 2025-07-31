<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

interface RequestManagerInterface
{
    public function add(string $ip, string $route, string $date): void;

    public function allow(string $ip, string $route, Config $config): bool;

    public function routeExist(?string $route): ?Config;
}
