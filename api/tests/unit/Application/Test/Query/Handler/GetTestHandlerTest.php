<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Query\Handler;

use App\Application\Test\Query\GetTest;
use App\Application\Test\Query\Handler\GetTestHandler;
use App\Application\Test\Reader\TestFullDataReader;
use App\Application\Test\View\TestFullDataView;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetTestHandlerTest extends TestCase
{
    private TestFullDataReader|MockObject $testDbalRepository;

    protected function setUp(): void
    {
        $this->testDbalRepository = $this->createMock(TestFullDataReader::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->testDbalRepository,
        );
    }

    public function testShouldHandleAndExecuteMessage(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $testFullData = new TestFullDataView($uuid->toString(), uniqid(), rand(1, 100));

        $this->testDbalRepository
            ->expects($this->once())
            ->method('all')
            ->willReturn([$testFullData]);

        // When
        $handler = $this->createInstanceUnderTest($this->testDbalRepository);

        // Then
        $this->assertSame([$testFullData], $handler->__invoke(new GetTest()));
    }

    private function createInstanceUnderTest(TestFullDataReader $testRepository): GetTestHandler
    {
        return new GetTestHandler($testRepository);
    }
}
