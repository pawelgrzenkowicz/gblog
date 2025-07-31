<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Command\Handler;

use App\Application\Test\Command\Handler\UpdateTestHandler;
use App\Application\Test\Command\UpdateTest;
use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use App\Domain\Shared\ValueObject\String\TestNameVO;
use App\Domain\Test\Test;
use App\Domain\Test\TestRepositoryInterface;
use App\UI\Http\Rest\Error\ErrorType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UpdateTestHandlerTest extends TestCase
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
        $testUuid = Uuid::uuid4();
        $newName = uniqid();
        $newNumber = rand(1, 100);
        $test = new Test($testUuid, new TestNameVO(uniqid()), new TestNumberVO(rand(1,100)));
        $command = new UpdateTest($testUuid->toString(), $newName, $newNumber);

        $this->testRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($testUuid)
            ->willReturn($test);

        $this->testRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function(Test $test) use ($testUuid, $newName, $newNumber) {

                    $this->assertEquals($testUuid, $test->uuid);
                    $this->assertEquals($newName, $test->name());
                    $this->assertEquals($newNumber, $test->number()->toInteger());

                    return true;
                })
            );

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    public function testShouldThrowException(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $command = new UpdateTest($uuid->toString(), uniqid(), rand(1, 100));

        $this->testRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn(null);

        // Exception
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(ErrorType::TEST_NOT_FOUND->value);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    private function createInstanceUnderTest(): UpdateTestHandler
    {
        return new UpdateTestHandler($this->testRepository);
    }
}
