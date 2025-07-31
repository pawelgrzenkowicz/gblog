<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\User\Command\Handler;

use App\Application\User\Command\DeleteUser;
use App\Application\User\Command\Handler\DeleteUserHandler;
use App\Application\User\Exception\UserNotFoundException;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Tests\unit\_OM\Domain\UserMother;
use App\UI\Http\Rest\Error\ErrorType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteUserHandlerTest extends TestCase
{
    private UserRepositoryInterface|MockObject $userRepository;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->userRepository,
        );
    }

    public function testShouldRemoveUser(): void
    {
        // Given
        $user = UserMother::createDefault();

        // When
        $this->userRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid = $user->uuid)
            ->willReturn($user);

        $this->userRepository
            ->expects($this->once())
            ->method('delete')
            ->with(
                $this->callback(function (User $user) use ($uuid) {

                    $this->assertSame($uuid, $user->uuid);

                    return true;
                })
            );

        $this->createInstanceUnderTest()->__invoke(new DeleteUser($user->uuid->toString()));
    }

    public function testShouldThrowExceptionWheUserNotFound(): void
    {
        // Given
        $uuid = Uuid::uuid4();

        // When
        $this->userRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn(null);

        // Exception
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage(ErrorType::USER_NOT_FOUND->value);
        $this->expectExceptionCode(404);

        // Then
        $this->createInstanceUnderTest()->__invoke(new DeleteUser($uuid->toString()));
    }

    private function createInstanceUnderTest(): DeleteUserHandler
    {
        return new DeleteUserHandler($this->userRepository);
    }
}
