<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use App\Infrastructure\Request\Configuration\CreateTest;
use App\Infrastructure\Request\Configuration\CreateUser;

class RequestConfiguration
{
    /**
     * @return Config[]
     */
    public static function get(): array
    {
        return [
            new CreateTest(),
            new CreateUser(),
        ];
    }
}
