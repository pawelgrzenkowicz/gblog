<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\User\Query\Handler;

use App\Application\User\Query\GetUserEmail;
use App\Application\User\Query\Handler\GetUserEmailHandler;
use App\Application\User\Reader\UserEmailReader;
use App\Application\User\View\UserEmailView;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetUserEmailHandlerTest extends TestCase
{
    private UserEmailReader|MockObject $testDbalRepository;

    protected function setUp(): void
    {
        $this->testDbalRepository = $this->createMock(UserEmailReader::class);
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
        $testFullData = new UserEmailView($uuid->toString(), sprintf('%s@test.com', uniqid()));
        $query = new GetUserEmail($uuid->toString());

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

    private function createInstanceUnderTest(UserEmailReader $testRepository): GetUserEmailHandler
    {
        return new GetUserEmailHandler($testRepository);
    }
}
