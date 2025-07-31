<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Payload\User;

use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Payload\Payload;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class CreateUserPayload extends Payload
{
    protected static function getConstraints(): array
    {
        return array_merge(
            [
                'email' => [
                    new Email(message: ErrorType::INVALID_DATA->value),
                    new NotBlank(message: ErrorType::VALUE_CANNOT_BE_EMPTY->value),
                ],
                'nickname' => [
                    new Length(
                        min: 3,
                        max: 30,
                        minMessage: ErrorType::VALUE_TOO_SHORT->value,
                        maxMessage: ErrorType::VALUE_TOO_LONG->value
                    )
                ],
            ],
            PasswordPayload::getConstraints(),
        );
    }
}
