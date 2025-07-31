<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure;

use App\Application\Test\Command\CreateTest;
use App\Application\Test\Query\GetTest;
use App\Application\Test\View\TestFullDataView;
use App\Infrastructure\Symfony\Messenger\SimpleMessageBusInterface;
use App\Infrastructure\SymfonyApplication;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SymfonyApplicationTest extends TestCase
{
    private SimpleMessageBusInterface|MockObject $command;

    private SimpleMessageBusInterface|MockObject $query;

    protected function setUp(): void
    {
        $this->command = $this->createMock(SimpleMessageBusInterface::class);
        $this->query = $this->createMock(SimpleMessageBusInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->command,
            $this->query,
            $this->simpleMessageBus,
        );
    }

    public function testShouldAsk(): void
    {
        // Given
        $data = [
            new TestFullDataView('b8c735d9-e2ed-4955-90cd-6c19bed935f3', "Paweł", 12),
            new TestFullDataView('b8c735d9-e2ed-4955-90cd-6c19bed935f3', "Pawełek", 15),
        ];

        $this->query
            ->expects($this->once())
            ->method('dispatch')
            ->with($query = new GetTest())
            ->willReturn($data);

        // Then
        $this->assertEquals($data, $this->createInstanceUnderTest($this->command, $this->query)->ask($query));
    }

    public function testShouldExecute(): void
    {
        // Given
        $this->command
            ->expects($this->once())
            ->method('dispatch')
            ->with($command = new CreateTest(uniqid(), 12))
            ->willReturn(null);

        // Then
        $this->assertEquals(null, $this->createInstanceUnderTest($this->command, $this->query)->execute($command));
    }

    private function createInstanceUnderTest(
        SimpleMessageBusInterface $command,
        SimpleMessageBusInterface $query
    ): SymfonyApplication {
        return new SymfonyApplication($command, $query);
    }
}
