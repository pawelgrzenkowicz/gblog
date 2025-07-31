<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Request;

use App\Infrastructure\Request\GenerateRequest;
use App\Infrastructure\Request\Request;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class GenerateRequestTest extends TestCase
{
    private const string DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';

    public function testShouldGenerateValidObject(): void
    {
        // Given
        $request = new Request(
            new RequestIPVO($ip = '127.0.0.1'),
            new RequestRouteVO($route = uniqid()),
            new Carbon($date = self::DEFAULT_DATETIME)
        );

        // When
        $instanceUnderTest = $this->createInstanceUnderTest();

        // Then
        $this->assertEquals($request->ip(), $instanceUnderTest->generate($ip, $route, $date)->ip());
        $this->assertEquals($request->route(), $instanceUnderTest->generate($ip, $route, $date)->route());
        $this->assertEquals($request->date(), $instanceUnderTest->generate($ip, $route, $date)->date());
    }

    private function createInstanceUnderTest(): GenerateRequest
    {
        return new GenerateRequest();
    }
}
