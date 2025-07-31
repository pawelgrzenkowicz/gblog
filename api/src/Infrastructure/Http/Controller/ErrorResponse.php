<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use JsonSerializable;

readonly class ErrorResponse implements JsonSerializable
{
    public function __construct(
        public string $type
    ) { }

    public function jsonSerialize(): array
    {
        return [
            'type' => $this->type,
        ];
    }
}
