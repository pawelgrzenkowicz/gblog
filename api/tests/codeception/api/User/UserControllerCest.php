<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\User;

use App\Tests\codeception\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Codeception\Util\HttpCode;

class UserControllerCest
{
    private const string EXIST_EMAIL = 'Test-1-ROLE_FREE_USER@gmail.com';
    private const string EXIST_UUID = '531a514f-0bc3-4f8e-a398-cbf78ce6f5f5';
    private const string NON_EXIST_UUID = '6b27f9b1-1ba8-494d-8529-7ea4fe997e44';

    use UserLogin;

    private bool $initialized = false;

    public function _before(ApiTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        $I->clearDb('users');
        $I->loadSqlFile('dev.users.users_insert.sql');

        $this->initialized = true;
    }

    # GET #

    public function testShouldGetUserEmail(ApiTester $I): void
    {
        $I->sendGet(sprintf('api/users/%s/email', self::EXIST_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode([
            "uuid" => self::EXIST_UUID,
            "email" => self::EXIST_EMAIL
        ]));
    }

    public function testShouldGetUserEmailAndReturnUserNotFound(ApiTester $I): void
    {
        $I->sendGet(sprintf('api/users/%s/email', self::NON_EXIST_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseEquals(json_encode(["type" => "USER_NOT_FOUND"]));
    }

    # PUT #

    // TODO - po przerobieniu payload przy edycji hasła - dodać testy - czy hasła są identyczne?

    private function provideExceptionsForEditUserPassword(): array
    {
        return [
            [
                'body' => [
                    "oldPassword" => "Wrong_password123!",
                    "password" => "Password123!!",
                    "plainPassword" => "Password123!!"
                ],
                'response' => ["type" => "WRONG_PASSWORD"],
                'code' => 400,
            ],
            [
                'body' => [
                    "oldPassword" => "Wrong_password123!",
                    "password" => "Password123!! ",
                    "plainPassword" => "Password123!! "
                ],
                'response' => ["errors" => ["password" => [
                    "INVALID_STRING_CONTAIN_WHITESPACE"
                ]]],
                'code' => 400,
            ],
        ];
    }

    #[DataProvider('provideExceptionsForEditUserPassword')]
    public function testShouldThrowExceptionWhenEditUserPassword(ApiTester $I, Example $example): void
    {
        $this->userLogin($I);

        $I->sendPut('api/users/password', json_encode($example['body']));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs($example['code']);
        $I->seeResponseEquals(json_encode($example['response']));
    }

    public function testShouldEditUserPassword(ApiTester $I): void
    {
        $this->userLogin($I);

        $I->sendPut('api/users/password', json_encode([
            "oldPassword" => "Password123!",
            "password" => "Password123!!",
            "plainPassword" => "Password123!!"
        ]));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(200);
    }

    # Login after change password #

    public function testShouldLoginAfterEditUserPassword(ApiTester $I): void
    {
        $this->login($I, self::EXIST_EMAIL, 'Password123!!');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(200);
    }

    # DELETE #

    private function provideExceptionsForDeleteUser(): array
    {
        return [
            [
                'uuid' => self::EXIST_UUID,
                'email' => 'coscos123@gmail.com',
                'password' => 'Password123!',
                'code' => 403,
                'response' => ["type" => "ACCESS_DENIED"],
            ],
            [
                'uuid' => self::NON_EXIST_UUID,
                'email' => 'admin@admin.admin',
                'password' => 'Tamto123!',
                'code' => 404,
                'response' => ["type" => "USER_NOT_FOUND"],
            ],
        ];
    }

    #[DataProvider('provideExceptionsForDeleteUser')]
    public function testShouldThrowExceptionWhenDeleteUser(ApiTester $I, Example $example): void
    {
        $this->login($I, $example['email'], $example['password']);
        $I->sendDelete(sprintf('/api/users/%s', $example['uuid']));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs($example['code']);
        $I->seeResponseEquals(json_encode($example['response']));
    }

    public function testShouldDeleteUser(ApiTester $I): void
    {
        $this->adminLogin($I);
        $I->sendDelete(sprintf('/api/users/%s', self::EXIST_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(200);
    }
}
