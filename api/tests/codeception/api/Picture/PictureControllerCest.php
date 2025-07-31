<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\Picture;

use App\Tests\codeception\api\User\UserLogin;
use App\Tests\codeception\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Codeception\Util\HttpCode;

class PictureControllerCest
{
    private const string EXIST_SOURCE = 'article/content/2024/TEST-small.jpg';
    private const string NON_EXIST_SOURCE = 'article/content/2024/TEST_not_exist.jpg';

    use UserLogin;

    private bool $initialized = false;

    public function _before(ApiTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        $I->clearDb('pictures');
        $I->clearDb('users');

        $I->loadSqlFile('dev.pictures.pictures_insert.sql');
        $I->loadSqlFile('dev.users.users_insert.sql');

        $this->initialized = true;
    }

    private function provideAccessDeniedData(): array
    {
        return [
            [
                'method' => 'POST',
                'url' => 'api/pictures',
            ],
            [
                'method' => 'DELETE',
                'url' => 'api/pictures/61d445c0-6a30-4b52-885c-1b26bfaae578',
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
        $I->seeResponseEquals(json_encode(['type' => 'ACCESS_DENIED']));
    }

    # POST #

    public function testShouldAddNewPicture(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->unsetHttpHeader('Content-Type');

        $I->sendPost(
            'api/pictures',
            [
                'source' => $source = 'article/content/2024/TEST-1',
                'alt' => $alt = 'TEST alt'
            ],
            [
                'picture' => codecept_data_dir('files/dragon-ball-db2.jpg'),
            ]
        );

        $I->haveHttpHeader('Content-Type', 'multipart/form-data');
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->seeInDatabase('pictures', [
            'source' => sprintf('%s%s', $source, '.jpg'),
            'alt' => $alt,
            'extension' => 'jpg'
        ]);
    }

    # DELETE #

    public function testShouldThrowExceptionWhenDeletePicture(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->unsetHttpHeader('Content-Type');

        $I->sendDelete(sprintf('api/pictures/%s', self::NON_EXIST_SOURCE));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    public function testShouldDeletePicture(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->unsetHttpHeader('Content-Type');

        $I->sendDelete(sprintf('api/pictures/%s', self::EXIST_SOURCE));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->dontSeeInDatabase('pictures', ['source' => self::EXIST_SOURCE]);

        $entries = $I->grabEntriesFromDatabase('pictures', ['source' => self::EXIST_SOURCE]);

        // Then
        $I->assertEmpty($entries);
    }
}
