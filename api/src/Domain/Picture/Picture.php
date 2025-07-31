<?php

declare(strict_types=1);

namespace App\Domain\Picture;

use App\Domain\External;
use App\Domain\ExternalTrait;
use App\Domain\Internal;
use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Domain\Shared\ValueObject\String\PictureNameVO;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use Ramsey\Uuid\UuidInterface;

class Picture
{
    private const string NAME_REGEX = '/\/([^\/]+)\.[^.]+$/';

    use ExternalTrait;

    #[Internal]
    public readonly UuidInterface $uuid;

    #[External]
    private PictureAltVO $alt;

    #[External]
    private PictureExtension $extension;

    #[External]
    private PictureNameVO $name;

    #[External]
    private PictureSourceVO $source;

    public function __construct(
        UuidInterface $uuid,
        PictureAltVO $alt,
        PictureExtension $extension,
        PictureSourceVO $source
    ) {
        $this->uuid = $uuid;
        $this->alt = $alt;
        $this->extension = $extension;
        $this->source = $source;
        $this->name = new PictureNameVO($this->pictureName($source->value));
    }

    public function alt(): PictureAltVO
    {
        return $this->alt;
    }

    public function extension(): PictureExtension
    {
        return $this->extension;
    }

    public function name(): PictureNameVO
    {
        return $this->name;
    }

    public function source(): PictureSourceVO
    {
        return $this->source;
    }

    public function toArray(): array
    {
        return [
            'alt' => $this->alt->value,
            'extension' => $this->extension->value,
            'source' => $this->source->value,
        ];
    }

    public function pictureName(string $source): string
    {
        preg_match(self::NAME_REGEX, $source, $matches);

        return !$matches ? $source : $matches[1];
    }

    public function pictureNameFormatter(PictureSourceVO $source): string
    {
        preg_match(self::NAME_REGEX, $source->value, $matches);

        return !$matches ? $source->value : $matches[1];
    }
}
