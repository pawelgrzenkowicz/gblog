<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Number;

use App\Domain\Shared\ValueObject\LogMessage;
use Assert\Assert;

final readonly class NaturalNumberVO
{
    public int $value;

    public function __construct(int $value)
    {
        Assert::that($value)
            ->min(0, LogMessage::log(self::class, (string)$value));

        $this->value = $value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    public function toInteger(): int
    {
        return $this->value;
    }
}
