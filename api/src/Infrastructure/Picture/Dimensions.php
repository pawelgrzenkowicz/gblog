<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture;

use App\Infrastructure\Picture\Formats\Format;

final readonly class Dimensions
{
    public function __construct(public float $width, public float $height) {}
}
