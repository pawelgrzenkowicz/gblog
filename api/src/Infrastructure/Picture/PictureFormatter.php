<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture;

use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureFileStorage;
use App\Domain\Picture\PictureFormatterInterface;
use App\Infrastructure\Filesystem\DirectoryInterface;
use App\Infrastructure\Picture\Formats\FormatBuilderInterface;

final readonly class PictureFormatter implements PictureFormatterInterface
{
    private const string ORIGINAL_FOLDER_NAME = 'original';

    public function __construct(
        private PictureFileStorage $pictureFiles,
        private ResizerInterface $resizer,
        private DirectoryInterface $directory,
        private FormatBuilderInterface $formatBuilder,
    ) {
    }

    public function remove(string $path): void
    {
        $this->directory->remove($this->useSource(self::ORIGINAL_FOLDER_NAME, $path));

        foreach (FormatTypes::get() as $type) {
            $this->directory->remove($this->useSource($type->getLocation(), $path));
        }
    }

    public function run(Picture $picture): void
    {
        $originalFile = $this->pictureFiles->get($picture);

        $this->directory->link(
            $this->useSource(self::ORIGINAL_FOLDER_NAME, $source = $picture->source()->value),
            $originalFile
        );

        foreach (FormatTypes::get() as $type) {
            list($width, $height) = getimagesize($originalFile->getPathname());

            $format = $this->formatBuilder->build($height, $width, $type);

            if ($dimensions = $this->resizer->newDimensions($originalFile, $format)) {
                $this->directory->put(
                    $format->location . '/' . $source,
                    $this->resizer->resize($originalFile, $dimensions)
                );
            } else {
                $this->directory->link(
                    $format->location . '/' . $source,
                    $originalFile
                );
            }
        }
    }

    private function useSource(string $location, string $path): string
    {
        return sprintf('%s/%s', $location, $path);
    }
}
