<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Service;

class TemporaryRouteGenerator
{
    public function generate(string $prefix): string
    {
        return tempnam(sys_get_temp_dir(), $prefix);
    }
}
