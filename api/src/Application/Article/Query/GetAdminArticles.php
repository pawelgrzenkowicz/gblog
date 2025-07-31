<?php

declare(strict_types=1);

namespace App\Application\Article\Query;

use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;

readonly class GetAdminArticles
{
    public function __construct(public Pagination $pagination, public Sort $sort) {}
}
