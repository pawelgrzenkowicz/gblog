<?php

declare(strict_types=1);

namespace App\Tests\codeception\functional\Infrastructure\User\Repository;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\Shared\ValueObject\String\NicknameVO;
use App\Infrastructure\User\Repository\UserRepository;
use App\Tests\codeception\FunctionalTester;
use Ramsey\Uuid\Uuid;

class UserRepositoryCest
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

    public function testShouldGetUserByUuid(FunctionalTester $I): void
    {
        // Given
        /** @var UserRepository $repo */
        $repo = $I->getClass(UserRepository::class);

        // When
        $user = $repo->byUuid(Uuid::fromString(self::EXIST_UUID));

        // Then
        $I->assertNotEmpty($user);
        $I->assertSame(self::EXIST_UUID, $user->uuid->toString());
        $I->assertSame(self::EXIST_USER_EMAIL, $user->email()->__toString());
        $I->assertSame(self::EXIST_USER_NICKNAME, $user->nickname()->__toString());
        $I->assertSame('ROLE_FREE_USER', $user->role()->value);
        $I->assertTrue($user->password()->matches('Password123!'));
        $I->assertfalse($user->removed());
    }

    public function testShouldGetUserByNickname(FunctionalTester $I): void
    {
        // Given
        /** @var UserRepository $repo */
        $repo = $I->getClass(UserRepository::class);

        // When
        $user = $repo->byNickname(new NicknameVO(self::EXIST_USER_NICKNAME));

        // Then
        $I->assertNotEmpty($user);
        $I->assertSame(self::EXIST_UUID, $user->uuid->toString());
        $I->assertSame(self::EXIST_USER_EMAIL, $user->email()->__toString());
        $I->assertSame(self::EXIST_USER_NICKNAME, $user->nickname()->__toString());
        $I->assertSame('ROLE_FREE_USER', $user->role()->value);
        $I->assertTrue($user->password()->matches('Password123!'));
        $I->assertfalse($user->removed());
    }

    public function testShouldGetUserByEmail(FunctionalTester $I): void
    {
        // Given
        /** @var UserRepository $repo */
        $repo = $I->getClass(UserRepository::class);

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

    # DELETE #

    public function testShouldSoftDeleteUser(FunctionalTester $I): void
    {
        // Given
        /** @var UserRepository $repo */
        $repo = $I->getClass(UserRepository::class);

        // When
        $user = $repo->byEmail(new EmailVO(self::EXIST_USER_EMAIL));
        $repo->delete($user);

        $entry = $I->grabEntryFromDatabase('users', ['uuid' => self::EXIST_UUID]);

        // Then
        $I->assertNotEmpty($user);
        $I->assertSame(self::EXIST_UUID, $user->uuid->toString());
        $I->assertSame(self::EXIST_USER_EMAIL, $user->email()->__toString());
        $I->assertSame(self::EXIST_USER_NICKNAME, $user->nickname()->__toString());
        $I->assertSame('ROLE_FREE_USER', $user->role()->value);
        $I->assertTrue($user->password()->matches('Password123!'));
        $I->assertSame(1, $entry['removed']);
    }
}
