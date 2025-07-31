<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\Application\Shared;

use App\Application\Shared\Pagination;

class PaginationMother
{
    private const int DEFAULT_PAGE = 1;
    private const int DEFAULT_LIMIT = 10;

    public static function create(int $page, int $limit): Pagination
    {
        return new Pagination($page, $limit);
    }

    public static function createDefault(): Pagination
    {
        return self::create(
            self::DEFAULT_PAGE,
            self::DEFAULT_LIMIT
        );
    }
}
