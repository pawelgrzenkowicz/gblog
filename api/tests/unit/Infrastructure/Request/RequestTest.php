<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Request;

use App\Infrastructure\Request\Request;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    private const string DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';

    public function testShouldCreateValidObject(): void
    {
        // Given
        $ip = new RequestIPVO('127.0.0.1');
        $route = new RequestRouteVO(uniqid());
        $date = new Carbon(self::DEFAULT_DATETIME);

        // When
        $request = $this->createInstanceUnderTest($ip, $route, $date);

        // Then
        $this->assertSame($ip, $request->ip());
        $this->assertSame($route, $request->route());
        $this->assertSame($date, $request->date());
    }

    private function createInstanceUnderTest(RequestIPVO $ip, RequestRouteVO $route, CarbonInterface $date): Request
    {
        return new Request($ip, $route, $date);
    }
}
