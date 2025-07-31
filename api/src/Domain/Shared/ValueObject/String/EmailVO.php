<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\LogMessage;
use Assert\Assert;

final readonly class EmailVO
{
    public string $value;

    public function __construct(string $value)
    {
        Assert::that($value)
            ->email(LogMessage::log(self::class, $value));

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
