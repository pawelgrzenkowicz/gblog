<?php

declare(strict_types=1);

namespace App\Infrastructure\Request;

use App\Domain\ExternalTrait;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Carbon\CarbonInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Request
{
    use ExternalTrait;

    public readonly UuidInterface $uuid;

    private CarbonInterface $date;

    private RequestIPVO $ip;

    private RequestRouteVO $route;

    public function __construct(
        RequestIPVO    $ip,
        RequestRouteVO $route,
        CarbonInterface  $date
    ) {
        $this->uuid = Uuid::uuid4();
        $this->ip = $ip;
        $this->route = $route;
        $this->date = $date;
    }

    public function date(): CarbonInterface
    {
        return $this->date;
    }

//    public function date(): RequestDateVO
//    {
//        return $this->date;
//    }

    public function ip(): RequestIPVO
    {
        return $this->ip;
    }

    public function route(): RequestRouteVO
    {
        return $this->route;
    }
}
