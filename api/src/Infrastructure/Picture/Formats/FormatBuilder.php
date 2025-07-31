<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture\Formats;

final readonly class FormatBuilder implements FormatBuilderInterface
{
    public function build(float $height, float $width, ResizeFormat $resizeFormat): Format
    {
        return new Format(
            $height / $resizeFormat->getScaleDown(),
            $width / $resizeFormat->getScaleDown(),
            $resizeFormat->getLocation()
        );
    }
}
