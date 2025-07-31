<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\Application\Shared;

use App\Application\Shared\Sort;

class SortMother
{
    private const string DEFAULT_ORDER_BY = 'uuid';
    private const string DEFAULT_ORDER = 'desc';

    public static function create(string $orderBy, string $order): Sort
    {
        return new Sort($orderBy, $order);
    }

    public static function createDefault(): Sort
    {
        return self::create(
            self::DEFAULT_ORDER_BY,
            self::DEFAULT_ORDER
        );
    }
}
