<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\RequestLimiter;

use App\Tests\codeception\api\User\UserLogin;
use App\Tests\codeception\ApiTester;

class RequestLimiterCest
{
    private const string EXIST_IP = '127.0.0.1';

    use UserLogin;

    private bool $initialized = false;

    public function _before(ApiTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        $I->clearDb('requests');
        $I->clearDb('users');

        $I->loadSqlFile('dev.requests.requests_insert.sql');
        $I->loadSqlFile('dev.users.users_insert.sql');

        $this->initialized = true;
    }

    public function testShouldAddNewRequestRecordToDatabase(ApiTester $I): void
    {
        $this->userLogin($I);

        for ($i = 0; $i < 2; $i++) {
            $I->sendPost('api/tests', json_encode([
                'name' => uniqid(),
                'number' => rand(1, 100),
            ]));
        }
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(201);
    }

    public function testShouldAddNewRequestRecordToDatabase2(ApiTester $I): void
    {
        $this->userLogin($I);

        $I->sendPost('api/tests', json_encode([
            'name' => uniqid(),
            'number' => rand(1, 100),
        ]));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(429);
        $I->seeResponseEquals(json_encode(["type" => "TOO_MANY_REQUESTS"]));
    }
}
