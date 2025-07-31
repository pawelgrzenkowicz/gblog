<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Payload\Article;

use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Payload\Payload;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final readonly class GetArticleBySlugPayload extends Payload
{
    protected static function getConstraints(): array
    {
        return [
            'slug' => [
                new NotBlank(message: ErrorType::VALUE_CANNOT_BE_EMPTY->value),
                new Type(type: 'string', message: ErrorType::INVALID_DATA->value),
            ],
        ];
    }
}
