<?php

declare(strict_types=1);

namespace App\Domain\Picture;

interface PictureFormatterInterface
{
    public function remove(string $path): void;

    public function run(Picture $picture): void;
}
