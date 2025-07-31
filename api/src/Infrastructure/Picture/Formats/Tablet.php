<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture\Formats;

final class Tablet implements ResizeFormat
{
    private const string LOCATION = 'medium';
    private const float SCALE_DOWN = 1.5;

    public function getLocation(): string
    {
        return self::LOCATION;
    }

    public function getScaleDown(): float
    {
        return self::SCALE_DOWN;
    }
}
