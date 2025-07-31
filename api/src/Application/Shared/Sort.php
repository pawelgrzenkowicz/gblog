<?php

declare(strict_types=1);

namespace App\Application\Shared;

final readonly class Sort
{
    public function __construct(public string $orderBy, public string $order) {}
}
