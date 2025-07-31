<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Command\Handler;

use App\Application\Test\Command\DeleteTest;
use App\Application\Test\Command\Handler\DeleteTestHandler;
use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use App\Domain\Shared\ValueObject\String\TestNameVO;
use App\Domain\Test\Test;
use App\Domain\Test\TestRepositoryInterface;
use App\UI\Http\Rest\Error\ErrorType;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteTestHandlerTest extends TestCase
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
        $uuid = Uuid::uuid4();
        $command = new DeleteTest($uuid->toString());
        $test = new Test($uuid, new TestNameVO($testName = uniqid()), new TestNumberVO($testNumber = rand(1, 100)));

        // When
        $this->testRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn($test);

        $this->testRepository
            ->expects($this->once())
            ->method('delete')
            ->with(
                $this->callback(function(Test $test) use ($uuid, $testName, $testNumber) {

                    $this->assertEquals($uuid, $test->uuid);
                    $this->assertEquals($testName, $test->name()->__toString());
                    $this->assertEquals($testNumber, $test->number()->toInteger());

                    return true;
                })
            );


        $this->createInstanceUnderTest()->__invoke($command);
    }

    public function testShouldThrowException(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $command = new DeleteTest($uuid->toString());

        // When
        $this->testRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn(null);

        // Exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage(ErrorType::TEST_NOT_FOUND->value);

        $this->createInstanceUnderTest()->__invoke($command);
    }

    private function createInstanceUnderTest(): DeleteTestHandler
    {
        return new DeleteTestHandler($this->testRepository);
    }
}
