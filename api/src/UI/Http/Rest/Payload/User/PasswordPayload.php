<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Payload\User;

use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Payload\Payload;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

final readonly class PasswordPayload extends Payload
{
    protected static function getConstraints(): array
    {
        return [
            'password' => [
                new Length(
                    min: 3,
                    max: 50,
                    minMessage: ErrorType::VALUE_TOO_SHORT->value,
                    maxMessage: ErrorType::VALUE_TOO_LONG->value
                ),
                new Regex('/[A-Z]+/', message: ErrorType::INVALID_PASSWORD_UPPERCASE->value),
                new Regex('/[a-z]+/', message: ErrorType::INVALID_PASSWORD_LOWERCASE->value),
                new Regex('/[!#$%&\'()*+,-.\/:;<=>?@\[\]^_`{|}~"]/', message: ErrorType::INVALID_PASSWORD_SPECIAL_CHARACTER->value),
                new Regex('/\d/', message: ErrorType::INVALID_PASSWORD_NUMBER->value),
                new Regex('/^\S*$/', message: ErrorType::INVALID_STRING_CONTAIN_WHITESPACE->value),
            ],
        ];
    }
}
