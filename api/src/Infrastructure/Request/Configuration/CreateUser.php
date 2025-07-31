<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\Configuration;

use App\Infrastructure\Request\Config;

class CreateUser extends Config
{
    private CONST int REQUEST_LIMIT = 5;
    private CONST string ROUTE = 'user.create';
    private CONST string TIME_FRAME = '1 day';

    public function __construct()
    {
        parent::__construct(self::ROUTE, self::REQUEST_LIMIT, self::TIME_FRAME);
    }
}
