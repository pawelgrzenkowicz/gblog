<?php

declare(strict_types=1);

namespace App\Tests\codeception\api;

use App\Tests\codeception\ApiTester;

class DeleteAllRecordsInDatabaseCest
{
    private bool $initialized = false;

    public function _before(ApiTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        if ($_ENV['APP_ENV'] === 'dev') {
            $I->clearDb('users');
            $I->clearDb('articles');
            $I->clearDb('pictures');
            $I->clearDb('tests');
            $I->clearDb('refresh_tokens');
            $I->clearDb('requests');
        }

        $this->initialized = true;
    }

    public function testShouldRemoveAll(ApiTester $I): void
    {
        $I->assertTrue(true);
    }
}
