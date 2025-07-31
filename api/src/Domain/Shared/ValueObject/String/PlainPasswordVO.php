<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\LogMessage;
use Assert\Assert;
use Stringable;

final readonly class PlainPasswordVO implements Stringable
{
    public string $value;

    public function __construct(string $value)
    {
        Assert::that($value)
            ->minLength(8, LogMessage::log(self::class, $value))
            ->maxLength(50, LogMessage::log(self::class, $value))
            ->regex('/[A-Z]+/', LogMessage::log(self::class, $value))
            ->regex('/[a-z]+/', LogMessage::log(self::class, $value))
            ->regex('/[!#$%&\'()*+,-.\/:;<=>?@\[\]^_`{|}~"]/', LogMessage::log(self::class, $value))
            ->regex('/\d/', LogMessage::log(self::class, $value))
            ->notContains(' ', LogMessage::log(self::class, $value))
        ;

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
