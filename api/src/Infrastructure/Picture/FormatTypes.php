<?php

declare(strict_types=1);

namespace App\Infrastructure\Picture;

use App\Infrastructure\Picture\Formats\Mobile;
use App\Infrastructure\Picture\Formats\ResizeFormat;
use App\Infrastructure\Picture\Formats\Tablet;

class FormatTypes
{
    /**
     * @return ResizeFormat[]
     */
    public static function get(): array
    {
        return [
            new Mobile(),
            new Tablet(),
        ];
    }
}
