<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\Configuration;

use App\Infrastructure\Request\Config;

class CreateTest extends Config
{
    private CONST int REQUEST_LIMIT = 2;
    private CONST string ROUTE = 'test.create';
    private CONST string TIME_FRAME = '10 hour';

    public function __construct()
    {
        parent::__construct(self::ROUTE, self::REQUEST_LIMIT, self::TIME_FRAME);
    }
}
