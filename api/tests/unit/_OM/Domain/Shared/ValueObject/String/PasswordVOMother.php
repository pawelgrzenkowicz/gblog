<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\String\PasswordVO;
use App\Domain\Shared\ValueObject\String\PlainPasswordVO;
use mimic;

final class PasswordVOMother
{
    public static function exactly(string $value): PasswordVO
    {
        return mimic\hydrate(PasswordVO::class, ['value' => $value]);
    }

    public static function fromPlainPasswordVO(PlainPasswordVO $plainPasswordVO): PasswordVO
    {
        return PasswordVO::fromPlainPassword($plainPasswordVO);
    }

    public static function random(): PasswordVO
    {
        return self::exactly(uniqid());
    }
}
