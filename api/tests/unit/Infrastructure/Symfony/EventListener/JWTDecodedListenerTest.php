<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Symfony\EventListener;

use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Symfony\EventListener\JWTDecodedListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTDecodedListenerTest extends TestCase
{
    private RequestStack|MockObject $requestStack;
    private UserRepositoryInterface|MockObject $userRepository;

    protected function setUp(): void
    {
        $this->requestStack = $this->createMock(RequestStack::class);
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->requestStack,
            $this->userRepository,
        );
    }

    public function testShouldCreateValidObject(): void
    {
        // When
        $actual = $this->createInstanceUnderTest();

        // Then
        $this->assertInstanceOf(JWTDecodedListener::class, $actual);
    }

    public function testShouldCheckInvokeFunction(): void
    {
        // Given
        $event = new JWTDecodedEvent([]);

        // When
        $this->createInstanceUnderTest()->__invoke($event);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    private function createInstanceUnderTest(): JWTDecodedListener
    {
        return new JWTDecodedListener($this->requestStack, $this->userRepository);
    }
}
