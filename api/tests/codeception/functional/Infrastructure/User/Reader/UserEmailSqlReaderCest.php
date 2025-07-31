<?php

declare(strict_types=1);

namespace App\Tests\codeception\functional\Infrastructure\User\Reader;

use App\Application\User\View\UserEmailView;
use App\Infrastructure\User\Reader\UserEmailSqlReader;
use App\Tests\codeception\FunctionalTester;
use Ramsey\Uuid\Uuid;

class UserEmailSqlReaderCest
{
    private const string EXIST_UUID = 'd8e9c8a5-3a0a-4186-bd4c-4fbe5e040d59';
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
        /** @var UserEmailSqlReader $reader */
        $reader = $I->getClass(UserEmailSqlReader::class);

        // When
        /** @var UserEmailView $user */
        $user = $reader->byUuid(Uuid::fromString(self::EXIST_UUID));

        // Then
        $I->assertNotEmpty($user);
        $I->assertSame(self::EXIST_UUID, $user->uuid);
        $I->assertSame(self::EXIST_USER_EMAIL, $user->email);
    }
}
