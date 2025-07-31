<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Security\User;

use App\Infrastructure\Security\User\JWTUser;
use PHPUnit\Framework\TestCase;

class JWTUserTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $email = uniqid();
        $password = uniqid();
        $role = uniqid();

        // When
        $jwtUser = $this->createInstanceUnderTest($email, $password, $role);

        // Then
        $this->assertEquals($email, $jwtUser->getUserIdentifier());
        $this->assertEquals($password, $jwtUser->getPassword());
        $this->assertEquals([$role], $jwtUser->getRoles());
        $this->assertNull($jwtUser->eraseCredentials());
    }

    public function createInstanceUnderTest(string $email, string $password, string $role): JWTUser
    {
        return new JWTUser($email, $password, $role);
    }
}
