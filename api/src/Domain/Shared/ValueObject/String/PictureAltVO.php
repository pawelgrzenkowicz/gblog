<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\LogMessage;
use Assert\Assert;

final readonly class PictureAltVO
{
    public string $value;

    public function __construct(string $value)
    {
        Assert::that($value)
            ->minLength(1, LogMessage::log(self::class, $value));

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
