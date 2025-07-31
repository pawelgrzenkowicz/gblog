<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\User;

use App\Tests\codeception\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;

class CreateUserControllerCest
{
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

    # POST #

    private function provideExceptionsForCreateUser(): array
    {
        return [
            'invalid email' => [
                'body' => [
                    'email' => 'cos',
                    'nickname' => 'Pawel',
                    'password' => 'Password123!',
                ],
                'code' => 400,
                'response' => ["errors" => ["email" => ["INVALID_DATA"]]],
            ],
            'empty email' => [
                'body' => [
                    'email' => '',
                    'nickname' => 'Pawel',
                    'password' => 'Password123!',
                ],
                'code' => 400,
                'response' => ["errors" => ["email" => ["VALUE_CANNOT_BE_EMPTY"]]],
            ],
            'nickname too short' => [
                'body' => [
                    'email' => 'new@new.new',
                    'nickname' => 'Pa',
                    'password' => 'Password123!',
                ],
                'code' => 400,
                'response' => ["errors" => ["nickname" => ["VALUE_TOO_SHORT"]]],
            ],
            'nickname too long' => [
                'body' => [
                    'email' => 'new@new.new',
                    'nickname' => 'P123456789P123456789P1234567890',
                    'password' => 'Password123!',
                ],
                'code' => 400,
                'response' => ["errors" => ["nickname" => ["VALUE_TOO_LONG"]]],
            ],
            'empty password' => [
                'body' => [
                    'email' => 'new@new.new',
                    'nickname' => 'Paweł',
                    'password' => '',
                ],
                'code' => 400,
                'response' => ["errors" => ["password" => ["VALUE_TOO_SHORT"]]],
            ],
            'invalid password' => [
                'body' => [
                    'email' => 'new@new.new',
                    'nickname' => 'Paweł',
                    'password' => ' ',
                ],
                'code' => 400,
                'response' => ["errors" => ["password" => [
                    "VALUE_TOO_SHORT",
                    "PASSWORD_NOT_CONTAIN_UPPERCASE_CHARACTER",
                    "PASSWORD_NOT_CONTAIN_LOWERCASE_CHARACTER",
                    "PASSWORD_NOT_CONTAIN_SPECIAL_CHARACTER",
                    "PASSWORD_NOT_CONTAIN_NUMBER",
                    "INVALID_STRING_CONTAIN_WHITESPACE"
                ]]],
            ],
            'password contain whitespace' => [
                'body' => [
                    'email' => 'new@new.new',
                    'nickname' => 'Paweł',
                    'password' => 'Test123! ',
                ],
                'code' => 400,
                'response' => ["errors" => ["password" => [
                    "INVALID_STRING_CONTAIN_WHITESPACE"
                ]]],
            ],
            'email already exist' => [
                'body' => [
                    'email' => 'admin@admin.admin',
                    'nickname' => 'Paweł',
                    'password' => 'Password123!',
                ],
                'code' => 422,
                'response' => ["type" => "USER_EMAIL_ALREADY_EXIST"],
            ],
            'nickname already exist' => [
                'body' => [
                    'email' => 'admin1@admin.admin',
                    'nickname' => 'ADMIN',
                    'password' => 'Password123!',
                ],
                'code' => 422,
                'response' => ["type" => "USER_NICKNAME_ALREADY_EXIST"],
            ],
        ];
    }

    #[DataProvider('provideExceptionsForCreateUser')]
    public function testShouldThrowExceptionWhenCreateUser(ApiTester $I, Example $example): void
    {
        $I->clearDb('requests');

        $I->sendPost('/api/users', json_encode($example['body']));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs($example['code']);
        $I->seeResponseEquals(json_encode($example['response']));
    }

    public function testShouldCreateUser(ApiTester $I): void
    {
        $I->clearDb('requests');

        $I->sendPost('/api/users', json_encode([
            'email' => 'new@new.new',
            'nickname' => 'New',
            'password' => 'Password123!',
        ]));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(201);
    }
}
