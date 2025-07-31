<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Symfony\Messenger;

use App\Application\Test\Query\GetTest;
use App\Infrastructure\Symfony\Messenger\SimpleMessageBus;
use App\Tests\unit\_OM\_Symfony\Component\Messenger\EnvelopeMother;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class SimpleMessageBusTest extends TestCase
{
    private MessageBusInterface $bus;

    protected function setUp(): void
    {
        $this->bus = $this->createMock(MessageBusInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->bus,
        );
    }

    public function testShouldDispatchMessage(): void
    {
        // Given
        $this->bus
            ->expects($this->once())
            ->method('dispatch')
            ->with($message = new GetTest())
            ->willReturn(EnvelopeMother::randomlyHandled($message, null));

        // When
        $this->createInstanceUnderTest($this->bus)->dispatch($message);
    }

    private function createInstanceUnderTest(MessageBusInterface $bus): SimpleMessageBus
    {
        return new SimpleMessageBus($bus);
    }
}
