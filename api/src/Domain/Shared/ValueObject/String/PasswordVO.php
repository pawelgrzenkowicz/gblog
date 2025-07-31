<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\String;

use Stringable;

final readonly class PasswordVO implements Stringable
{
    public const string ALGORITHM = PASSWORD_BCRYPT;
    public const int COST = 13;

    private function __construct(private string $value)
    {}

    public static function fromPlainPassword(PlainPasswordVO $value): self
    {
        return new self(
            self::hash((string) $value)
        );
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function matches(string $value): bool
    {
        return password_verify($value, $this->value);
    }

    private static function hash(string $password): string
    {
        return password_hash($password, self::ALGORITHM, ['cost' => self::COST]);
    }
}
