<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\User\Command\Handler;

use App\Application\User\Command\CreateUser;
use App\Application\User\Command\Handler\CreateUserHandler;
use App\Application\User\Exception\UserEmailAlreadyExistException;
use App\Application\User\Exception\UserNicknameAlreadyExistException;
use App\Domain\Shared\Enum\Role;
use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Domain\Shared\ValueObject\String\PlainPasswordVO;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Tests\unit\_OM\Domain\RoleMother;
use App\Tests\unit\_OM\Domain\Shared\ValueObject\String\PasswordVOMother;
use App\Tests\unit\_OM\Domain\UserMother;
use App\UI\Http\Rest\Error\ErrorType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateUserHandlerTest extends TestCase
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

    public function testShouldCreateValidObject(): void
    {
        // Given
        $email = sprintf('%s@gmail.com', uniqid());
        $nickname = uniqid();
        $plainPassword = 'CosCos123!';

        $command = new CreateUser($email, $nickname, $plainPassword, $role = Role::FREE_USER);

        $this->userRepository
            ->expects($this->once())
            ->method('byEmail')
            ->with($email)
            ->willReturn(null);

        $this->userRepository
            ->expects($this->once())
            ->method('byNickname')
            ->with($nickname)
            ->willReturn(null);

        $this->userRepository
            ->expects($this->once())
            ->method('uniqueUuid')
            ->willReturn($uuid = Uuid::uuid4());


        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (User $user) use ($uuid, $email, $nickname, $plainPassword, $role) {

                    $this->assertSame($uuid, $user->uuid);
                    $this->assertSame($email, $user->email()->__toString());
                    $this->assertSame($nickname, $user->nickname()->__toString());
                    $this->assertTrue($user->password()->matches($plainPassword));
                    $this->assertSame($role, $user->role());

                    return true;
                })
            );

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    public function testShouldThrowErrorWhenUserEmailExist(): void
    {
        // Given
        $plainPassword = 'CosCos123!';
        $user = UserMother::create(
            Uuid::uuid4(),
            new EmailVO($email = sprintf('%s@gmail.com', uniqid())),
            new NicknameVO($nickname = uniqid()),
            PasswordVOMother::fromPlainPasswordVO(new PlainPasswordVO($plainPassword)),
            RoleMother::createDefault()
        );

        $command = new CreateUser($email, $nickname, $plainPassword, Role::FREE_USER);

        $this->userRepository
            ->expects($this->once())
            ->method('byEmail')
            ->with($email)
            ->willReturn($user);

        // Exception
        $this->expectException(UserEmailAlreadyExistException::class);
        $this->expectExceptionMessage(ErrorType::USER_EMAIL_ALREADY_EXIST->value);
        $this->expectExceptionCode(422);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    public function testShouldThrowErrorWhenUserNicknameExist(): void
    {
        // Given
        $plainPassword = 'CosCos123!';
        $user = UserMother::create(
            Uuid::uuid4(),
            new EmailVO($email = sprintf('%s@gmail.com', uniqid())),
            new NicknameVO($nickname = uniqid()),
            PasswordVOMother::fromPlainPasswordVO(new PlainPasswordVO($plainPassword)),
            RoleMother::createDefault()
        );

        $command = new CreateUser($email, $nickname, $plainPassword, Role::FREE_USER);

        $this->userRepository
            ->expects($this->once())
            ->method('byEmail')
            ->with($email)
            ->willReturn(null);

        $this->userRepository
            ->expects($this->once())
            ->method('byNickname')
            ->with($nickname)
            ->willReturn($user);

        // Exception
        $this->expectException(UserNicknameAlreadyExistException::class);
        $this->expectExceptionMessage(ErrorType::USER_NICKNAME_ALREADY_EXIST->value);
        $this->expectExceptionCode(422);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    private function createInstanceUnderTest(): CreateUserHandler
    {
        return new CreateUserHandler($this->userRepository);
    }
}
