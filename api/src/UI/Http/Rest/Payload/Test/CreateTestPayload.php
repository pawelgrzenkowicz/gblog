<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Payload\Test;

use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Payload\Payload;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

final readonly class CreateTestPayload extends Payload
{
    protected static function getConstraints(): array
    {
        return [
            'name' => [
                new NotBlank(message: ErrorType::VALUE_CANNOT_BE_EMPTY->value),
            ],
            'number' => [
                new GreaterThanOrEqual(1, message: ErrorType::VALUE_IS_TOO_LOW->value),
                new LessThanOrEqual(100, message: ErrorType::VALUE_IS_TOO_HIGH->value),
            ],
        ];
    }
}
