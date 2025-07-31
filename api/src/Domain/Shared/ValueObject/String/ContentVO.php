<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\String;

final readonly class ContentVO
{
    public string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
