<?php

declare(strict_types=1);

namespace App\Domain\Picture;

use SplFileInfo;

interface PictureFileStorage
{
    public function get(Picture $picture): SplFileInfo;

    public function delete(Picture $picture): void;

    public function put(Picture $picture, SplFileInfo $file): void;
}
