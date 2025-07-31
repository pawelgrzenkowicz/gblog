<?php

declare(strict_types=1);

namespace App\Application\Picture\Query;

use App\Domain\Shared\ValueObject\String\PictureSourceVO;

readonly class GetPicture
{
    public PictureSourceVO $pictureSource;

    public function __construct(string $source)
    {
        $this->pictureSource = new PictureSourceVO($source);
    }
}
