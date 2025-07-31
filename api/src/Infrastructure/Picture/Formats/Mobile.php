<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture\Formats;

final class Mobile implements ResizeFormat
{
    private const string LOCATION = 'small';
    private const float SCALE_DOWN = 2;

    public function getLocation(): string
    {
        return self::LOCATION;
    }

    public function getScaleDown(): float
    {
        return self::SCALE_DOWN;
    }
}
