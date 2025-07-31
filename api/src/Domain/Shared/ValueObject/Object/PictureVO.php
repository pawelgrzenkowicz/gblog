<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Object;

use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;

final readonly class PictureVO
{
    public PictureAltVO $alt;

    public PictureExtension $extension;

    public PictureSourceVO $source;

    public function __construct(string $source, string $alt, string $extension)
    {
        $this->alt = new PictureAltVO($alt);
        $this->source = new PictureSourceVO($source);
        $this->extension = PictureExtension::fromString($extension);
    }

    public function toArray(): array
    {
        return [
            'alt' => $this->alt->value,
            'extension' => $this->extension->value,
            'source' => $this->source->value,
        ];
    }

    public function pictureName(): string
    {
        preg_match('/\/([^\/]+)\.[^.]+$/', $this->source->value, $matches);

        return !$matches ? $this->source->value : $matches[1];
    }
}
