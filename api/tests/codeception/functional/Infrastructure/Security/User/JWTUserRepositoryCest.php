<?php

declare(strict_types=1);

namespace App\Tests\codeception\functional\Infrastructure\Security\User;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Infrastructure\Security\User\JWTUserRepository;
use App\Tests\codeception\FunctionalTester;


class JWTUserRepositoryCest
{
    private const string EXIST_UUID = 'd8e9c8a5-3a0a-4186-bd4c-4fbe5e040d59';
    private const string EXIST_USER_NICKNAME = 'coscos123';
    private const string EXIST_USER_EMAIL = 'coscos123@gmail.com';

    private bool $initialized = false;

    public function _before(FunctionalTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        $I->clearDb('users');
        $I->loadSqlFile('dev.users.users_insert.sql');

        $this->initialized = true;
    }

    public function testShouldGetUserByEmail(FunctionalTester $I): void
    {
        // Given
        /** @var JWTUserRepository $repo */
        $repo = $I->getClass(JWTUserRepository::class);

        // When
        $user = $repo->byEmail(new EmailVO(self::EXIST_USER_EMAIL));

        // Then
        $I->assertNotEmpty($user);
        $I->assertSame(self::EXIST_UUID, $user->uuid->toString());
        $I->assertSame(self::EXIST_USER_EMAIL, $user->email()->__toString());
        $I->assertSame(self::EXIST_USER_NICKNAME, $user->nickname()->__toString());
        $I->assertSame('ROLE_FREE_USER', $user->role()->value);
        $I->assertTrue($user->password()->matches('Password123!'));
        $I->assertfalse($user->removed());
    }

    public function testShouldReturnNullWhenUserNotFound(FunctionalTester $I): void
    {
        // Given
        /** @var JWTUserRepository $repo */
        $repo = $I->getClass(JWTUserRepository::class);

        // When
        $user = $repo->byEmail(new EmailVO('NOT_EXIST_USER_EMAIL@email.com'));

        // Then
        $I->assertNull($user);
    }
}
