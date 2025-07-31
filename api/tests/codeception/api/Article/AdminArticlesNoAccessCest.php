<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\Article;

use App\Tests\codeception\api\User\UserLogin;
use App\Tests\codeception\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Codeception\Util\HttpCode;

class AdminArticlesNoAccessCest
{
    use UserLogin;

    private bool $initialized = false;

    public function _before(ApiTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        $I->clearDb('articles');
        $I->clearDb('pictures');
        $I->clearDb('users');
        $I->clearDb('requests');

        $I->loadSqlFile('dev.pictures.pictures_insert.sql');
        $I->loadSqlFile('dev.articles.articles_visible_insert.sql');
        $I->loadSqlFile('dev.articles.articles_not_visible_insert.sql');
        $I->loadSqlFile('dev.users.users_insert.sql');

        $this->initialized = true;
    }

    private function provideAccessDeniedData(): array
    {
        return [
            [
                'method' => 'POST',
                'url' => 'api/admin/articles',
            ],
            [
                'method' => 'GET',
                'url' => 'api/admin/articles',
            ],
            [
                'method' => 'GET',
                'url' => 'api/admin/articles/uuid/61d445c0-6a30-4b52-885c-1b26bfaae578',
            ],
            [
                'method' => 'GET',
                'url' => 'api/admin/articles/test_slug',
            ],
            [
                'method' => 'GET',
                'url' => 'api/admin/articles/61d445c0-6a30-4b52-885c-1b26bfaae578',
            ],
            [
                'method' => 'DELETE',
                'url' => 'api/admin/articles/61d445c0-6a30-4b52-885c-1b26bfaae578',
            ],
        ];
    }

    #[DataProvider('provideAccessDeniedData')]
    public function testShouldReturnAccessDeniedOnUserTry(ApiTester $I, Example $example): void
    {
        $this->userLogin($I);

        $I->send($example['method'], $example['url']);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
        $I->seeResponseContains(json_encode(['type' => 'ACCESS_DENIED']));
    }
}
