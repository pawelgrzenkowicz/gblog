<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture\Formats;

interface FormatBuilderInterface
{
    public function build(float $height, float $width, ResizeFormat $resizeFormat): Format;
}
