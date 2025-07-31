<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\User\Command\Handler;

use App\Application\Exception\InvalidDataException;
use App\Application\Shared\Error;
use App\Application\User\Command\EditUserPassword;
use App\Application\User\Command\Handler\EditUserPasswordHandler;
use App\Application\User\Exception\UserNotFoundException;
use App\Application\User\Exception\WrongPasswordException;
use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Domain\Shared\ValueObject\String\PlainPasswordVO;
use App\Domain\User\TokenDecoderInterface;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;
use App\Tests\unit\_OM\Domain\RoleMother;
use App\Tests\unit\_OM\Domain\Shared\ValueObject\String\PasswordVOMother;
use App\Tests\unit\_OM\Domain\UserMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class EditUserPasswordHandlerTest extends TestCase
{
    private UserRepositoryInterface|MockObject $userRepository;
    private TokenDecoderInterface|MockObject $tokenDecoder;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->tokenDecoder = $this->createMock(TokenDecoderInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->userRepository,
            $this->tokenDecoder,
        );
    }

    public function testShouldCreateValidObject(): void
    {
        // Given
        $oldPlainPassword = 'OldCosCos123!';
        $newPassword = 'CosCos123!';
        $newPlainPassword = new PlainPasswordVO($newPassword);
        $user = UserMother::create(
            Uuid::uuid4(),
            $email = new EmailVO(sprintf('%s@gmail.com', uniqid())),
            new NicknameVO(uniqid()),
            PasswordVOMother::fromPlainPasswordVO(new PlainPasswordVO($oldPlainPassword)),
            RoleMother::createDefault()
        );

        $this->tokenDecoder
            ->expects($this->once())
            ->method('decodeEmail')
            ->willReturn($email);

        $this->userRepository
            ->expects($this->once())
            ->method('byEmail')
            ->with($email)
            ->willReturn($user);

        $this->userRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (User $user) use ($newPlainPassword) {

                    $this->assertTrue($user->password()->matches($newPlainPassword->__toString()));
                    return true;
                })
            );

        // When
        $this->createInstanceUnderTest()->__invoke(new EditUserPassword($oldPlainPassword, $newPassword));
    }

    public function testShouldThrowErrorWhenUserEmailDoesNotExist(): void
    {
        // Given
        $oldPlainPassword = 'OldCosCos123!';
        $newPlainPassword = 'CosCos123!';

        $this->tokenDecoder
            ->expects($this->once())
            ->method('decodeEmail')
            ->willReturn(null);

        // Exception
        $this->expectException(InvalidDataException::class);
        $this->expectExceptionMessage(Error::INVALID_DATA->value);
        $this->expectExceptionCode(400);

        // When
        $this->createInstanceUnderTest()->__invoke(new EditUserPassword($oldPlainPassword, $newPlainPassword));
    }

    public function testShouldThrowErrorWhenUserNotFound(): void
    {
        // Given
        $oldPlainPassword = 'OldCosCos123!';
        $newPlainPassword = 'CosCos123!';
        $email = new EmailVO(sprintf('%s@gmail.com', uniqid()));

        $this->tokenDecoder
            ->expects($this->once())
            ->method('decodeEmail')
            ->willReturn($email);

        $this->userRepository
            ->expects($this->once())
            ->method('byEmail')
            ->with($email)
            ->willReturn(null);

        // Exception
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage(Error::USER_NOT_FOUND->value);
        $this->expectExceptionCode(404);

        // When
        $this->createInstanceUnderTest()->__invoke(new EditUserPassword($oldPlainPassword, $newPlainPassword));
    }

    public function testShouldThrowErrorWhenUserPasswordDoesNotMatch(): void
    {
        // Given
        $oldPlainPassword = 'OldCosCos123!';
        $newPlainPassword = 'CosCos123!';
        $user = UserMother::create(
            Uuid::uuid4(),
            $email = new EmailVO(sprintf('%s@gmail.com', uniqid())),
            new NicknameVO(uniqid()),
            PasswordVOMother::fromPlainPasswordVO(new PlainPasswordVO($oldPlainPassword . 1)),
            RoleMother::createDefault()
        );

        $this->tokenDecoder
            ->expects($this->once())
            ->method('decodeEmail')
            ->willReturn($email);

        $this->userRepository
            ->expects($this->once())
            ->method('byEmail')
            ->with($email)
            ->willReturn($user);

        // Exception
        $this->expectException(WrongPasswordException::class);
        $this->expectExceptionMessage(Error::WRONG_PASSWORD->value);
        $this->expectExceptionCode(400);

        // When
        $this->createInstanceUnderTest()->__invoke(new EditUserPassword($oldPlainPassword, $newPlainPassword));
    }

    private function createInstanceUnderTest(): EditUserPasswordHandler
    {
        return new EditUserPasswordHandler($this->userRepository, $this->tokenDecoder);
    }
}
