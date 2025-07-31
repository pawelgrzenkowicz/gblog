<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture;

use App\Infrastructure\Picture\Formats\Format;
use SplFileInfo;

interface ResizerInterface
{
    public function resize(SplFileInfo $file, Dimensions $dimensions): SplFileInfo;

    public function newDimensions(SplFileInfo $file, Format $format): ?Dimensions;
}
