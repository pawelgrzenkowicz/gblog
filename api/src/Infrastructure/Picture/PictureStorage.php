<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture;

use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureFileStorage;
use App\Infrastructure\Filesystem\DirectoryInterface;
use App\Infrastructure\Symfony\Error;
use InvalidArgumentException;
use SplFileInfo;

final readonly class PictureStorage implements PictureFileStorage
{
    public function __construct(private DirectoryInterface $directory) {}

    public function get(Picture $picture): SplFileInfo
    {
        return $this->directory->get($picture->source()->value);
    }

    public function delete(Picture $picture): void
    {
        $this->directory->remove($picture->source()->value);
    }

    public function put(Picture $picture, SplFileInfo $file): void
    {
        if (!$file->isReadable()) {
            throw new InvalidArgumentException(Error::PICTURE_IS_NOT_READABLE->value);
        }

        $this->directory->put($picture->source()->value, $file);
    }
}
