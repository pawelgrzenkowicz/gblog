<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Symfony\EventListener;

use App\Infrastructure\Request\Config;
use App\Infrastructure\Request\RequestManagerInterface;
use App\Infrastructure\Symfony\EventListener\RequestLimitListener;
use Codeception\PHPUnit\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\KernelInterface;

class RequestLimitListenerTest extends TestCase
{
    private RequestManagerInterface|MockObject $requestManager;

    protected function setUp(): void
    {
        $this->requestManager = $this->createMock(RequestManagerInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->requestManager,
        );
    }

    public function testShouldDoNothingWhenRouteDoesntExist(): void
    {
        // Given
        $event = new RequestEvent(
            $this->createMock(KernelInterface::class),
            new Request(attributes: ['_route' => $route = uniqid()]),
            null
        );

        $this->requestManager
            ->expects($this->once())
            ->method('routeExist')
            ->with($route)
            ->willReturn(null);

        // When
        $this->createInstanceUnderTest()->__invoke($event);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldAddIPToDatabase(): void
    {
        // Given
        $event = new RequestEvent(
            $this->createMock(KernelInterface::class),
            new Request(attributes: ['_route' => $route = uniqid()], server: ['REMOTE_ADDR' => $ip = '127.0.0.1']),
            null
        );

        $config = $this->createMock(Config::class);

        $this->requestManager
            ->expects($this->once())
            ->method('routeExist')
            ->with($route)
            ->willReturn($config);

        $this->requestManager
            ->expects($this->once())
            ->method('allow')
            ->with($ip, $route, $config)
            ->willReturn(true);

        $this->requestManager
            ->expects($this->once())
            ->method('add')
            ->with($ip, $route);

        // When
        $this->createInstanceUnderTest()->__invoke($event);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldThrowExceptionWhenTooManyRequests(): void
    {
        // Given
        $event = new RequestEvent(
            $this->createMock(KernelInterface::class),
            new Request(attributes: ['_route' => $route = uniqid()], server: ['REMOTE_ADDR' => $ip = '127.0.0.1']),
            null
        );

        $config = $this->createMock(Config::class);

        $this->requestManager
            ->expects($this->once())
            ->method('routeExist')
            ->with($route)
            ->willReturn($config);

        $this->requestManager
            ->expects($this->once())
            ->method('allow')
            ->with($ip, $route, $config)
            ->willReturn(false);

        // Exception
        $this->expectException(TooManyRequestsHttpException::class);
        $this->expectExceptionMessage('TOO_MANY_REQUESTS');
        $this->expectExceptionCode(429);

        // When
        $this->createInstanceUnderTest()->__invoke($event);
    }

    public function createInstanceUnderTest(): RequestLimitListener
    {
        return new RequestLimitListener($this->requestManager);
    }
}
