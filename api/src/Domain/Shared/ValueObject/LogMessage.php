<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

class LogMessage
{
    public static function log(string $class, string $value): string
    {
        return sprintf('file: %s, value: %s', $class, $value);
    }
}
