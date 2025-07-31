<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\LogMessage;
use Assert\Assert;

final readonly class CategoriesVO
{
    public string $value;

    public function __construct(string $values)
    {
        $arrayValues = explode(',', $values);

        Assert::that($arrayValues)
            ->maxCount(3, LogMessage::log(self::class, $values));

        $this->value = strtolower($values);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
