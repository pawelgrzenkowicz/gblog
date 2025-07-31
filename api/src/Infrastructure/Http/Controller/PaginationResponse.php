<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use JsonSerializable;

readonly class PaginationResponse implements JsonSerializable
{
    public function __construct(
        public array $items = [],
        public int $page = 1,
        public int $total = 0
    ) { }

    public function jsonSerialize(): array
    {
        return [
            'items' => $this->items,
            'page' => $this->page,
            'total' => $this->total,
        ];
    }
}
