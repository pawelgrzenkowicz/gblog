<?php

declare(strict_types=1);

namespace App\Application\Picture\Command;

use App\Domain\Shared\ValueObject\String\PictureSourceVO;

readonly class DeletePicture
{
    public PictureSourceVO $pictureSource;

    public function __construct(string $source)
    {
        $this->pictureSource = new PictureSourceVO($source);
    }
}
