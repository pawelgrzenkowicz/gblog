<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\ValueObject;

final readonly class RequestRouteVO
{
    public string $value;

    public function __construct(string $value)
    {
//        Assert::that($value)
//            ->inArray(Path::values(), LogMessage::log(self::class, $value));

        $this->value = $value;

//        dd(Path::namesValues()[$value]);
//        exit;
//        $this->value = Path::namesValues()[$value];
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
