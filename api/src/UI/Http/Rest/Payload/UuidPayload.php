<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Payload;

use App\UI\Http\Rest\Error\ErrorType;
use Symfony\Component\Validator\Constraints\Uuid;

final readonly class UuidPayload extends Payload
{
    protected static function getConstraints(): array
    {
        return [
            'uuid' => [
                new Uuid(message: ErrorType::INVALID_UUID->value),
            ],
        ];
    }
}
