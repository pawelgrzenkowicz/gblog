<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture;

use App\Infrastructure\Picture\Formats\Format;

final readonly class PictureOrientationCalculator implements PictureOrientationCalculatorInterface
{
    public function calculate(Format $format, float $ratio): Dimensions
    {
        $width = $format->width;
        $height = $format->height;

        if ($format->widthRatio() > $ratio) {
            $width = $height * $ratio;
        } else {
            $height = $width / $ratio;
        }

        return new Dimensions(round($width, 2), round($height, 2));
    }
}
