<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\User;

use App\Tests\codeception\ApiTester;

trait UserLogin
{
    protected function adminLogin(ApiTester $I): void
    {
        $this->login($I, 'admin@admin.admin', 'Tamto123!');
    }

    protected function login(ApiTester $I, string $email, string $password): void
    {
        $I->sendPostAsJson(
            '/api/login',
            ["email" => $email, "password" => $password]
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->amBearerAuthenticated($I->grabDataFromResponseByJsonPath('token')[0]);
    }

    protected function userLogin(ApiTester $I): void
    {
        $this->login($I, 'Test-1-ROLE_FREE_USER@gmail.com', 'Password123!');
    }
}
