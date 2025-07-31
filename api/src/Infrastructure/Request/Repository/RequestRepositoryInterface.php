<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\Repository;

use App\Infrastructure\Request\Request;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Carbon\CarbonInterface;

interface RequestRepositoryInterface
{
    public function count(RequestIPVO $ip, RequestRouteVO $route, CarbonInterface $date, string $timeFrame): int;

    public function save(Request $request): void;
}
