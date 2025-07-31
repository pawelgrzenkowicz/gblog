<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture\Formats;

class Format
{
    public function __construct(public float $height, public float $width, public string $location) {}

    public function heightRatio(): float
    {
        return round($this->height / $this->width, 2);
    }

    public function widthRatio(): float
    {
        return round($this->width / $this->height, 2);
    }
}
