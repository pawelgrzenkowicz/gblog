<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture;

use App\Infrastructure\Picture\Formats\Format;

interface PictureOrientationCalculatorInterface
{
    public function calculate(Format $format, float $ratio): Dimensions;
}
