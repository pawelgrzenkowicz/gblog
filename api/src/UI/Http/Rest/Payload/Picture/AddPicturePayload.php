<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Payload\Picture;

use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Payload\Payload;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

final readonly class AddPicturePayload extends Payload
{
    protected static function getConstraints(): array
    {
        return [
            'picture' => [
                new File(notFoundMessage: ErrorType::PICTURE_NOT_FOUND->value),
            ],
            'alt' => [
                new Length(min: 1, minMessage: ErrorType::VALUE_TOO_SHORT->value),
            ],
            'source' => [
                new Length(min: 1, minMessage: ErrorType::VALUE_TOO_SHORT->value),
                new Regex('/^\S*$/', message: ErrorType::INVALID_STRING_CONTAIN_WHITESPACE->value),
            ],
        ];
    }
}
