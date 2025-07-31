<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Payload\Test;

use App\UI\Http\Rest\Payload\Payload;
use App\UI\Http\Rest\Payload\UuidPayload;

final readonly class UpdateTestPayload extends Payload
{
    protected static function getConstraints(): array
    {
        return array_merge(
            UuidPayload::getConstraints(),
            CreateTestPayload::getConstraints(),
        );
    }
}
