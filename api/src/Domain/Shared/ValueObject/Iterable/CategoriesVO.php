<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Iterable;

use App\Domain\Shared\ValueObject\LogMessage;
use Assert\Assert;

final readonly class CategoriesVO
{
    public array $values;

    public function __construct(array $values)
    {
        $items = [];

        Assert::that($values)
            ->maxCount(3, LogMessage::log(self::class, (string)count($values)));

        foreach ($values as $value) {
            $items[] = strtolower($value);
        }

        $this->values = $items;
    }

    public function toArray(): array
    {
        return $this->values;
    }

    public function toString(): string
    {
        return implode(',', $this->values);
    }
}
