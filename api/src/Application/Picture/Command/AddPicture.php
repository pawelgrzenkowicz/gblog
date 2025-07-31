<?php

declare(strict_types=1);

namespace App\Application\Picture\Command;

use App\Domain\Shared\ValueObject\Object\PictureVO;
use SplFileInfo;

readonly class AddPicture
{
    public PictureVO $picture;

    public SplFileInfo $file;

    public function __construct(
        string $source,
        string $alt,
        string $extension,
        SplFileInfo $file
    ) {
        $this->picture = new PictureVO($source, $alt, $extension);
        $this->file = $file;
    }
}
