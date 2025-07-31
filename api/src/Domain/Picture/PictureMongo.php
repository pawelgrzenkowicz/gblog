<?php

declare(strict_types=1);

namespace App\Domain\Picture;

use App\Domain\External;
use App\Domain\ExternalTrait;
use App\Domain\Internal;
use App\Domain\Shared\ValueObject\Object\PictureVO;
use Ramsey\Uuid\UuidInterface;

class PictureMongo
{
    use ExternalTrait;

    #[Internal]
    public readonly UuidInterface $uuid;

    #[External]
    private PictureVO $picture;

    public function __construct(
        UuidInterface $uuid,
        PictureVO $picture
    ) {
        $this->uuid = $uuid;
        $this->picture = $picture;
    }

    public function picture(): PictureVO
    {
        return $this->picture;
    }
}
