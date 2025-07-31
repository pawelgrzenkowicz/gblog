<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Symfony\EventListener;

use App\Infrastructure\Symfony\Error;
use App\Infrastructure\Symfony\EventListener\AuthenticationFailureListener;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthenticationFailureListenerTest extends TestCase
{
    private AuthenticationFailureEvent|MockObject $authenticationFailureEvent;

    protected function setUp(): void
    {
        $this->authenticationFailureEvent = $this->createMock(AuthenticationFailureEvent::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->authenticationFailureEvent,
        );
    }

    public function testShouldThrowErrorWhenAuthFailEvent(): void
    {
        // Exception
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage(Error::BAD_CREDENTIALS->value);
        $this->expectExceptionCode(400);

        // Then
        $this->createInstanceUnderTest()->__invoke($this->authenticationFailureEvent);
    }

    private function createInstanceUnderTest(): AuthenticationFailureListener
    {
        return new AuthenticationFailureListener();
    }
}
