<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture;

use App\Infrastructure\Picture\Formats\Format;
use App\Infrastructure\Symfony\Service\TemporaryRouteGenerator;
use Imagine\Image\Box;
use Imagine\Imagick\Imagine;
use SplFileInfo;

final readonly class Resizer implements ResizerInterface
{
    public function __construct(
        private Imagine $imagine,
        private PictureOrientationCalculatorInterface $pictureOrientationCalculator,
        private TemporaryRouteGenerator $temporaryRouteGenerator
    ) {
    }

    public function resize(SplFileInfo $file, Dimensions $dimensions): SplFileInfo
    {
        $resizeFilePath = $this->temporaryRouteGenerator->generate('resize');
        $picture = $this->imagine->open($file->getPathname());
        $picture->resize(new Box($dimensions->width, $dimensions->height))->save($resizeFilePath);

        return new SplFileInfo($resizeFilePath);
    }

    public function newDimensions(SplFileInfo $file, Format $format): ?Dimensions
    {
        list($originalWidth, $originalHeight) = getimagesize($file->getPathname());
        $ratio = $originalWidth / $originalHeight;

        $width = $format->width;
        $height = $format->height;

        if ($originalHeight <= $height && $originalWidth <= $width) {
            return null;
        }

        return $this->pictureOrientationCalculator->calculate($format, $ratio);
    }
}
