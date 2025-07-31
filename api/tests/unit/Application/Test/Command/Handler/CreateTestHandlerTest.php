<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Command\Handler;

use App\Application\Test\Command\CreateTest;
use App\Application\Test\Command\Handler\CreateTestHandler;
use App\Domain\Test\Test;
use App\Domain\Test\TestRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateTestHandlerTest extends TestCase
{
    private TestRepositoryInterface|MockObject $testRepository;

    protected function setUp(): void
    {
        $this->testRepository = $this->createMock(TestRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->testRepository,
        );
    }

    public function testShouldHandleAndExecuteMessage(): void
    {
        // Given
        $testName = uniqid();
        $testNumber = rand(1, 100);

        $this->testRepository
            ->expects($this->once())
            ->method('uniqueUuid')
            ->willReturn($uuid = Uuid::uuid4());

        $this->testRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function(Test $test) use ($uuid, $testName, $testNumber) {

                    $this->assertSame($test->uuid, $uuid);
                    $this->assertSame($test->name()->__toString(), $testName);
                    $this->assertSame($test->number()->toInteger(), $testNumber);

                    return true;
                })
            );

        // When
        $handle = $this->createInstanceUnderTest()->__invoke(new CreateTest($testName, $testNumber));

        // Then
        $this->assertSame($uuid->toString(), $handle);
    }

    private function createInstanceUnderTest(): CreateTestHandler
    {
        return new CreateTestHandler($this->testRepository);
    }
}
