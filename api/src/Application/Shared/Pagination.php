<?php

declare(strict_types=1);

namespace App\Application\Shared;

final readonly class Pagination
{
    public function __construct(public int $page, public int $limit) {}
}
