<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture\Formats;

interface ResizeFormat
{
    public function getLocation(): string;
    public function getScaleDown(): float;
}
