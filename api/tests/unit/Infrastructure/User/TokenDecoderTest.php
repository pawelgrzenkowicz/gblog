<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\User;

use App\Domain\Shared\Enum\Role;
use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Infrastructure\Security\User\JWTUser;
use App\Infrastructure\User\TokenDecoder;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Authenticator\Token\JWTPostAuthenticationToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TokenDecoderTest extends TestCase
{
    private TokenStorageInterface|MockObject $tokenStorage;
    private JWTTokenManagerInterface $JWTTokenManager;

    protected function setUp(): void
    {
        $this->tokenStorage = $this->createMock(TokenStorageInterface::class);
        $this->JWTTokenManager = $this->createMock(JWTTokenManagerInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->tokenStorage,
            $this->JWTTokenManager,
        );
    }

    public function testShouldDecodeTokenAndEmail(): void
    {
        // Given
        $JWTUser = new JWTUser($email = 'test@test.test', uniqid(), $role = Role::FREE_USER->value);
        $JWTToken = new JWTPostAuthenticationToken($JWTUser, "api", [$role], $token = uniqid());
        $tokenPayload = ['username' => $email, 'roles' => [$role]];

        $this->tokenStorage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($JWTToken);

        $this->JWTTokenManager
            ->expects($this->once())
            ->method('decode')
            ->with($JWTToken)
            ->willReturn($tokenPayload);

        // When
        $actual = $this->createInstanceUnderTest()->decodeEmail();

        // Then
        $this->assertEquals(new EmailVO($email), $actual);
    }

    public function testShouldDecodeTokenAndReturnNull(): void
    {
        // Given
        $JWTUser = new JWTUser(uniqid(), uniqid(), $role = Role::FREE_USER->value);
        $JWTToken = new JWTPostAuthenticationToken($JWTUser, "api", [$role], $token = uniqid());

        $this->tokenStorage
            ->expects($this->once())
            ->method('getToken')
            ->willReturn($JWTToken);

        $this->JWTTokenManager
            ->expects($this->once())
            ->method('decode')
            ->with($JWTToken)
            ->willReturn(false);

        // When
        $actual = $this->createInstanceUnderTest()->decodeEmail();

        // Then
        $this->assertNull($actual);
    }

    private function createInstanceUnderTest(): TokenDecoder
    {
        return new TokenDecoder($this->tokenStorage, $this->JWTTokenManager);
    }
}
