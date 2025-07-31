<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Payload\Article;

use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Payload\Payload;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

final readonly class CreateArticlePayload extends Payload
{
    protected static function getConstraints(): array
    {
        return [
            'categories' => [],
            'createDate' => [
                new DateTime(format: 'Y-m-d\\TH:i', message: ErrorType::INVALID_DATA->value),
            ],
            'contents' => [
                new Collection([
                    'he' => [
                        new Type(type: 'string'),
                    ],
                    'she' => [
                        new Type(type: 'string'),
                    ],
                ]),
            ],
            'mainPictureFile' => [
                new File(notFoundMessage: ErrorType::PICTURE_NOT_FOUND->value),
            ],
            'mainPicture' => [
                new Collection([
                    'alt' => [
                        new Length(min: 1, minMessage: ErrorType::VALUE_TOO_SHORT->value),
                    ],
                    'source' => [
                        new Length(min: 1, minMessage: ErrorType::VALUE_TOO_SHORT->value),
                        new Regex('/^\S*$/', message: ErrorType::INVALID_STRING_CONTAIN_WHITESPACE->value),
                    ],
                ]),
            ],
            'publicationDate' => [
                new DateTime(format: 'Y-m-d\\TH:i', message: ErrorType::INVALID_DATA->value),
            ],
            'ready' => [
                new Collection([
                    'he' => [
                        new NotBlank(message: ErrorType::VALUE_CANNOT_BE_EMPTY->value),
                    ],
                    'she' => [
                        new NotBlank(message: ErrorType::VALUE_CANNOT_BE_EMPTY->value),
                    ],
                ]),
            ],
            'removed' => [
                new NotBlank(message: ErrorType::VALUE_CANNOT_BE_EMPTY->value),
            ],
            'slug' => [
                new NotBlank(message: ErrorType::VALUE_CANNOT_BE_EMPTY->value),
                new Length(min: 1, minMessage: ErrorType::VALUE_TOO_SHORT->value),
                new Regex('/^\S*$/', message: ErrorType::INVALID_STRING_CONTAIN_WHITESPACE->value),
            ],
            'title' => [
                new Length(min: 1, minMessage: ErrorType::VALUE_TOO_SHORT->value),
            ],

            'views' => [
                new NotBlank(message: ErrorType::VALUE_CANNOT_BE_EMPTY->value),
                new Regex(pattern: '/^(0|[1-9][0-9]*)$/', message: ErrorType::INVALID_DATA->value)
            ]
        ];
    }
}
