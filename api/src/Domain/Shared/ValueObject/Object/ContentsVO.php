<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Object;

use App\Domain\Shared\ValueObject\String\ContentVO;

final readonly class ContentsVO
{
    public function __construct(public ContentVO $he, public ContentVO $she) {}

    public function toArray(): array
    {
        return [
            'he' => $this->he->value,
            'she' => $this->she->value,
        ];
    }
}
