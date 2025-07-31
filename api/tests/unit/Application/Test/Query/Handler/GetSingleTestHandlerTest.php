<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Query\Handler;

use App\Application\Test\Query\GetSingleTest;
use App\Application\Test\Query\Handler\GetSingleTestHandler;
use App\Application\Test\Reader\TestFullDataReader;
use App\Application\Test\View\TestFullDataView;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetSingleTestHandlerTest extends TestCase
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
        $query = new GetSingleTest($uuid->toString());

        // When
        $this->testDbalRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($query->uuid)
            ->willReturn($testFullData);

        $handler = $this->createInstanceUnderTest($this->testDbalRepository);


        // Then
        $this->assertSame($testFullData, $handler->__invoke($query));
    }

    private function createInstanceUnderTest(TestFullDataReader $testRepository): GetSingleTestHandler
    {
        return new GetSingleTestHandler($testRepository);
    }
}
