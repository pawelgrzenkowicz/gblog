<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use App\Infrastructure\Request\ValueObject\RequestDateVO;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Carbon\Carbon;
use Carbon\CarbonInterface;

final readonly class GenerateRequest implements GenerateRequestInterface
{
    public function generate(string $ip, string $route, string $date): Request
    {
        return new Request(
            $this->ip($ip),
            $this->route($route),
            $this->date($date),
        );
    }

    public function date(string $date): CarbonInterface
    {
        return Carbon::create($date);
    }

    public function ip(string $path): RequestIPVO
    {
        return new RequestIPVO($path);
    }

    public function route(string $route): RequestRouteVO
    {
        return new RequestRouteVO($route);
    }
}
