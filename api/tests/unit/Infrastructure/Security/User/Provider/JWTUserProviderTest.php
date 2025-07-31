<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Security\User\Provider;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Domain\Shared\ValueObject\String\PlainPasswordVO;
use App\Domain\User\User;
use App\Infrastructure\Security\User\JWTUser;
use App\Infrastructure\Security\User\JWTUserRepositoryInterface;
use App\Infrastructure\Security\User\Provider\JWTUserProvider;
use App\Tests\unit\_OM\Domain\RoleMother;
use App\Tests\unit\_OM\Domain\Shared\ValueObject\String\PasswordVOMother;
use App\Tests\unit\_OM\Domain\UserMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JWTUserProviderTest extends TestCase
{
    private JWTUserRepositoryInterface|MockObject $repository;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(JWTUserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->repository,
        );
    }

    public function testShouldLodUserByIdentifier(): void
    {
        // Given
        $email = sprintf('%s@gmail.com', uniqid());
        $user = UserMother::create(
            Uuid::uuid4(),
            new EmailVO($email),
            new NicknameVO(uniqid()),
            PasswordVOMother::fromPlainPasswordVO(new PlainPasswordVO('CosCos123!')),
            RoleMother::createDefault()
        );

        $this->repository
            ->expects($this->once())
            ->method('byEmail')
            ->with(new EmailVO($email))
            ->willReturn($user);

        // When
        $actual = $this->createInstanceUnderTest()->loadUserByIdentifier($email);

        // Then
        $this->assertEquals($user->email()->__toString(), $actual->getUserIdentifier());
    }

    public function testShouldThrowExceptionWhenLoadUserByIdentifier(): void
    {
        // Given
        $email = sprintf('%s@gmail.com', uniqid());

        $this->repository
            ->expects($this->once())
            ->method('byEmail')
            ->with(new EmailVO($email))
            ->willReturn(null);

        // Exception
        $this->expectException(NotFoundHttpException::class);

        // When
        $this->createInstanceUnderTest()->loadUserByIdentifier($email);
    }

    public function testShouldRefreshUser(): void
    {
        // Then
        $this->assertSame($user = new JWTUser(uniqid(), uniqid(), uniqid()), $this->createInstanceUnderTest()->refreshUser($user));
    }

    public function testShouldSupportsClassAndReturnValidClass(): void
    {
        // Then
        $this->assertSame(User::class, $this->createInstanceUnderTest()->supportsClass(uniqid()));
    }

    private function createInstanceUnderTest(): JWTUserProvider
    {
        return new JWTUserProvider($this->repository);
    }
}
