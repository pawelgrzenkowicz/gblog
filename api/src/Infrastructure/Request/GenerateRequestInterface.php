<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Carbon\CarbonInterface;

interface GenerateRequestInterface
{
    public function generate(string $ip, string $route, string $date): Request;

    public function date(string $date): CarbonInterface;

    public function ip(string $path): RequestIPVO;

    public function route(string $route): RequestRouteVO;
}
