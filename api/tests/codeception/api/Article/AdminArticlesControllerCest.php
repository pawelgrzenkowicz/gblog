<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\Article;

use App\Tests\codeception\api\User\UserLogin;
use App\Tests\codeception\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Codeception\Util\HttpCode;
use SplFileInfo;

class AdminArticlesControllerCest
{
    private const string EXIST_UUID = 'cd6014ca-5c3e-4a0d-a8ba-24b0d3be9c96';
    private const string EXIST_UUID2 = 'df508751-d537-45db-a9e9-e6bb053e69c2';
    private const string NOT_VISIBLE_UUID = '61d445c0-6a30-4b52-885c-1b26bfaae578';
    private const string VISIBLE_UUID = '61d445c0-6a30-4b52-885c-1b26bfaae578';

    use ArticleResponseReader;
    use CopyImage;
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

        $I->loadSqlFile('dev.pictures.pictures_insert.sql');
        $I->loadSqlFile('dev.articles.articles_visible_insert.sql');
        $I->loadSqlFile('dev.articles.articles_not_visible_insert.sql');
        $I->loadSqlFile('dev.users.users_insert.sql');

        $this->initialized = true;
    }

    # GET #

    public function testShouldReturnArticleBySlug(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->sendGet(sprintf('api/admin/articles/%s', 'test-slug-01'));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode($this->getArticleList('admin-articles.json')[11]));
    }

    public function testShouldReturnArticleByUuid(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->sendGet(sprintf('api/admin/articles/uuid/%s', self::VISIBLE_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode($this->getArticleList('admin-articles.json')[12]));
    }

    public function testShouldReturnAdminArticlesWithoutParams(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->sendGet('api/admin/articles');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode([
            "items" => array_slice($this->getArticleList('admin-articles.json'), 0, 10),
            "page" => 1,
            "total" => 16
        ]));
    }

    private function provideParamsForGetAdminArticles(): array
    {
        $response = $this->getArticleList('admin-articles.json');
        return [
            [
                'params' => 'page=1&limit=3',
                'response' => ["items" => array_slice($response, 0, 3), "page" => 1, "total" => 16],
            ],
            [
                'params' => 'page=2&limit=4',
                'response' => ["items" => array_slice($response, 4, 4), "page" => 2, "total" => 16],
            ],
            [
                'params' => 'page=2&limit=10',
                'response' => ["items" => array_slice($response, 10, 6), "page" => 2, "total" => 16],
            ],
        ];
    }

    #[DataProvider('provideParamsForGetAdminArticles')]
    public function testShouldReturnAdminArticlesWithParams(ApiTester $I, Example $example): void
    {
        $this->adminLogin($I);

        $I->sendGet(sprintf('api/admin/articles?%s', $example['params']));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode($example['response']));
    }


    # POST #

    public function testShouldCreateArticle(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->unsetHttpHeader('Content-Type');

        $I->sendPost(
            'api/admin/articles',
            [
                'createDate' => '2023-11-16T07:50',
                'contents' => [
                    'he' => 'Jego TEST text',
                    'she' => 'Jej TEST text',
                ],
                'mainPicture' => [
                    'alt' => $alt = 'Dragon alt',
                    'source' => $source = 'article/main/2024/TEST-db-duze-102',
                ],
                'ready' => [
                    'he' => true,
                    'she' => true,
                ],
                'slug' => 'created-slug-1',
                'title' => 'created-title-1',
                'categories' => 'family,work,children',
                'views' => 0,
                'removed' => 0,
                'publicationDate' => null,
            ],
            [
                'mainPictureFile' => codecept_data_dir('files/dragon-ball-db.jpg')
            ]
        );

        $I->haveHttpHeader('Content-Type', 'multipart/form-data');
        $I->seeResponseCodeIs(HttpCode::CREATED);

        $I->seeNumRecords(17, 'articles');

        $I->seeInDatabase('pictures', [
            'source' => sprintf('%s%s', $source, '.jpg'),
            'alt' => $alt,
            'extension' => 'jpg'
        ]);
    }

    # EDIT #

    public function testShouldUpdateArticle(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->unsetHttpHeader('Content-Type');

        $I->sendPost(
            sprintf('api/admin/articles/%s', self::EXIST_UUID),
            [
                'createDate' => '2024-06-30T06:00',
                'contents' => [
                    'he' => 'Jego CHANGED TEST text',
                    'she' => 'Jej TEST CHANGED text',
                ],
                'mainPicture' => [
                    'alt' => 'Dragon alt changed',
                    'source' => 'article/main/2024/TEST-CHANGED-db-duze-102',
                ],
                'ready' => [
                    'he' => 0,
                    'she' => 0,
                ],
                'slug' => 'created-slug-1-changed',
                'title' => 'created-title-1-changed',
                'categories' => "children-changed,work-changed,family-changed",
                'views' => 10,
                'removed' => 1,
                'publicationDate' => '2024-06-30T06:00',
            ],
            [
                'mainPictureFile' => codecept_data_dir('files/dragon-ball-db2.jpg')
            ]
        );

        $I->haveHttpHeader('Content-Type', 'multipart/form-data');
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->unsetHttpHeader('Content-Type');

        $I->sendGet(sprintf('api/admin/articles/uuid/%s', self::EXIST_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode([
            "uuid" => "cd6014ca-5c3e-4a0d-a8ba-24b0d3be9c96",
            "contents" => [
                "he" => "Jego CHANGED TEST text",
                "she" => "Jej TEST CHANGED text"
            ],
            "createDate" => "2024-06-30T06:00:00+00:00",
            "mainPicture" => [
                "alt" => $alt = "Dragon alt changed",
                "extension" => "jpg",
                "source" => $source = "article/main/2024/TEST-CHANGED-db-duze-102.jpg"
            ],
            "slug" => "created-slug-1-changed",
            "title" => "created-title-1-changed",
            "categories" => "children-changed,work-changed,family-changed",
            "publicationDate" => "2024-06-30T06:00:00+00:00",
            "ready" => [
                "he" => false,
                "she" => false
            ],
            "removed" => true,
            "views" => 10,
            "mainPictureName" => "TEST-CHANGED-db-duze-102",
            "publicationDateFormatted" => "2024-06-30T06:00"
        ]));

        $I->seeInDatabase('pictures', [
            'source' => $source,
            'alt' => $alt,
            'extension' => 'jpg'
        ]);
    }

    public function testShouldUpdateArticleWithoutNewPictureFile(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->unsetHttpHeader('Content-Type');

        $file = new SplFileInfo(__DIR__ . '/../../../../public/core/dragon-ball-db.jpg');
        $newPath =  __DIR__ . '/../../../../images/storage/some/path/not-visible/2-command-dragon-ball-db.jpg';

        $this->copy($file, $newPath);

        $I->sendPost(
            sprintf('api/admin/articles/%s', self::EXIST_UUID2),
            [
                'createDate' => '2024-06-30T06:00',
                'contents' => [
                    'he' => 'Jego CHANGED TEST text',
                    'she' => 'Jej TEST CHANGED text',
                ],
                'mainPicture' => [
                    'alt' => 'Dragon alt changed',
                    'source' => 'some/path/not-visible/1-command-dragon-ball-db-CHANGED',
                ],
                'ready' => [
                    'he' => 0,
                    'she' => 0,
                ],
                'slug' => 'created-slug-1-changed-no-picture',
                'title' => 'created-title-1-changed',
                'categories' => "children-changed,work-changed,family-changed",
                'views' => 10,
                'removed' => 1,
                'publicationDate' => '2024-06-30T06:00',
            ]
        );

        $I->haveHttpHeader('Content-Type', 'multipart/form-data');
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->unsetHttpHeader('Content-Type');

        $I->sendGet(sprintf('api/admin/articles/uuid/%s', self::EXIST_UUID2));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode([
            "uuid" => "df508751-d537-45db-a9e9-e6bb053e69c2",
            "contents" => [
                "he" => "Jego CHANGED TEST text",
                "she" => "Jej TEST CHANGED text"
            ],
            "createDate" => "2024-06-30T06:00:00+00:00",
            "mainPicture" => [
                "alt" => $alt = "Dragon alt changed",
                "extension" => "jpg",
                "source" => $source = "some/path/not-visible/1-command-dragon-ball-db-CHANGED.jpg"
            ],
            "slug" => "created-slug-1-changed-no-picture",
            "title" => "created-title-1-changed",
            "categories" => "children-changed,work-changed,family-changed",
            "publicationDate" => "2024-06-30T06:00:00+00:00",
            "ready" => [
                "he" => false,
                "she" => false
            ],
            "removed" => true,
            "views" => 10,
            "mainPictureName" => "1-command-dragon-ball-db-CHANGED",
            "publicationDateFormatted" => "2024-06-30T06:00"
        ]));

        $I->seeInDatabase('pictures', [
            'source' => $source,
            'alt' => $alt,
            'extension' => 'jpg'
        ]);
    }

    # DELETE #

    public function testShouldDeleteArticle(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->sendDelete(sprintf('api/admin/articles/%s', self::VISIBLE_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->sendGet('api/visible/articles?limit=100');
        $visibleResponse = $I->grabDataFromResponseByJsonPath('items');
        $I->assertSame(10, count($visibleResponse[0]));
    }
}
