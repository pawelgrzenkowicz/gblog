<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\ValueObject;

use App\Domain\Shared\ValueObject\LogMessage;
use Assert\Assert;

final readonly class RequestIPVO
{
    public string $value;

    public function __construct(string $value)
    {
        Assert::that($value)
            ->ip(null, LogMessage::log(self::class, $value));

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
