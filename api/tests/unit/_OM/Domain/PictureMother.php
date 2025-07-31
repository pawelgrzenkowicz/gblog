<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\Domain;

use App\Domain\Picture\Picture;
use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PictureMother
{
    private const string DEFAULT_UUID = 'd230b5b8-ac88-4404-899b-600d511f3a94';
    private const string DEFAULT_ALT = 'Default Alt';
    private const string DEFAULT_SOURCE = 'some/url/name.jpg';

    public static function create(
        UuidInterface $uuid,
        PictureAltVO $alt,
        PictureExtension $extension,
        PictureSourceVO $source
    ): Picture {
        return new Picture($uuid, $alt, $extension, $source);
    }

    public static function createDefault(): Picture
    {
        return self::create(
            Uuid::fromString(self::DEFAULT_UUID),
            new PictureAltVO(self::DEFAULT_ALT),
            PictureExtension::JPG,
            new PictureSourceVO(self::DEFAULT_SOURCE),
        );
    }
}
