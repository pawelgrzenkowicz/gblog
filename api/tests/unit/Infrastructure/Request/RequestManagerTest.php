<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Request;

use App\Infrastructure\Request\Config;
use App\Infrastructure\Request\Configuration\CreateTest;
use App\Infrastructure\Request\Configuration\CreateUser;
use App\Infrastructure\Request\GenerateRequestInterface;
use App\Infrastructure\Request\Repository\RequestRepositoryInterface;
use App\Infrastructure\Request\Request;
use App\Infrastructure\Request\RequestManager;
use App\Infrastructure\Request\ValueObject\RequestIPVO;
use App\Infrastructure\Request\ValueObject\RequestRouteVO;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RequestManagerTest extends TestCase
{
    private const string DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';

    private GenerateRequestInterface|MockObject $generateRequest;

    private RequestRepositoryInterface|MockObject $requestRepository;

    protected function setUp(): void
    {
        $this->generateRequest = $this->createMock(GenerateRequestInterface::class);
        $this->requestRepository = $this->createMock(RequestRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->generateRequest,
            $this->requestRepository
        );
    }

    public function testShouldAddToDatabase(): void
    {
        // Given
        $ip = '127.0.0.1';
        $route = uniqid();
        $date = self::DEFAULT_DATETIME;

        $this->generateRequest
            ->expects($this->once())
            ->method('generate')
            ->with($ip, $route, $date)
            ->willReturn($request = $this->createMock(Request::class));

        $this->requestRepository
            ->expects($this->once())
            ->method('save')
            ->with($request);

        // When
        $this->createInstanceUnderTest()->add($ip, $route, $date);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public static function provideAllow(): array
    {
        return [
            [
                'ip' => '127.0.0.1',
                'route' => uniqid(),
                'config' => new CreateTest(),
                'count' => 1,
            ],
            [
                'ip' => '127.0.0.1',
                'route' => uniqid(),
                'config' => new CreateTest(),
                'count' => 0,
            ],
            [
                'ip' => '127.0.1.1',
                'route' => uniqid(),
                'config' => new CreateUser(),
                'count' => 1,
            ],
        ];
    }

    #[DataProvider('provideAllow')]
    public function testShouldAllowRequest(string $ip, string $route, Config $config, int $count): void
    {
        // Given
        $this->setAllow($ip, $route, $config, $count);

        // Then
        $this->assertTrue($this->createInstanceUnderTest()->allow($ip, $route, $config));
    }

    public static function provideDontAllow(): array
    {
        return [
            [
                'ip' => '127.0.0.1',
                'route' => uniqid(),
                'config' => new CreateTest(),
                'count' => 2,
            ],
            [
                'ip' => '127.0.1.1',
                'route' => uniqid(),
                'config' => new CreateUser(),
                'count' => 9999,
            ],
        ];
    }

    #[DataProvider('provideDontAllow')]
    public function testShouldNotAllowRequest(string $ip, string $route, Config $config, int $count): void
    {
        // Given
        $this->setAllow($ip, $route, $config, $count);

        // Then
        $this->assertFalse($this->createInstanceUnderTest()->allow($ip, $route, $config));
    }

    public static function provideRoutes(): array
    {
        return [
            [
                'route' => 'test.create',
            ]
        ];
    }

    #[DataProvider('provideRoutes')]
    public function testShouldReturnExistConfig(?string $route): void
    {
        // Then
        $this->assertEquals(new CreateTest(), $this->createInstanceUnderTest()->routeExist($route));
    }

    public static function provideDevProfilerRoutes(): array
    {
        return [
            [
                'route' => null,
            ],
            [
                'route' => '_profiler_home',
            ],
        ];
    }

    #[DataProvider('provideDevProfilerRoutes')]
    public function testShouldReturnNullWhenProfilerRouteIsUsed(?string $route): void
    {
        // Then
        $this->assertNull($this->createInstanceUnderTest()->routeExist($route));
    }

    public function testShouldReturnNullWhenRouteDoesNotExist(): void
    {
        // Then
        $this->assertNull($this->createInstanceUnderTest()->routeExist(uniqid()));
    }

    private function createInstanceUnderTest(): RequestManager
    {
        return new RequestManager($this->generateRequest, $this->requestRepository);
    }

    private function setAllow(string $ip, string $route, Config $config, int $count): void
    {
        $this->generateRequest
            ->expects($this->once())
            ->method('ip')
            ->with($ip)
            ->willReturn($requestIP = new RequestIPVO($ip));

        $this->generateRequest
            ->expects($this->once())
            ->method('route')
            ->with($route)
            ->willReturn($requestRoute = new RequestRouteVO($route));

        $this->generateRequest
            ->expects($this->once())
            ->method('date')
            ->willReturn($requestDate = new Carbon(self::DEFAULT_DATETIME));

        $this->requestRepository
            ->expects($this->once())
            ->method('count')
            ->with(
                $requestIP,
                $requestRoute,
                $requestDate,
                $config->timeFrame
            )
            ->willReturn($count);
    }
}
