<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enum;

use App\Domain\Shared\ValueObject\LogMessage;
use Assert\Assert;

enum PictureExtension: string
{
    case JPG = 'jpg';
    case JPEG = 'jpeg';
    case PNG = 'png';

    public static function fromString(string $extension): self
    {
        $pictureExtension = self::tryFrom($extension);

        Assert::that($pictureExtension)
            ->notNull(LogMessage::log(self::class, $extension));

        return $pictureExtension;
    }
}
