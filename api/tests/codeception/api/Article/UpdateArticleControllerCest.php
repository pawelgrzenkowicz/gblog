<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\Article;

use App\Tests\codeception\api\User\UserLogin;
use App\Tests\codeception\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;

class UpdateArticleControllerCest
{
    private const string EXIST_UUID2 = 'df508751-d537-45db-a9e9-e6bb053e69c2';

    use ArticleResponseReader;
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

    private function provideExceptionsForCreateArticle(): array
    {
        return [
            'empty slug' => [
                'body' => [
                    'createDate' => '2023-11-16T07:50',
                    'contents' => [
                        'he' => 'Jego TEST text',
                        'she' => 'Jej TEST text',
                    ],
                    'mainPicture' => [
                        'alt' => 'Dragon alt',
                        'source' => 'article/main/2024/TEST-db-duze-102',
                    ],
                    'ready' => [
                        'he' => true,
                        'she' => true,
                    ],
                    'slug' => '',
                    'title' => 'created-title-1',
                    'categories' => 'family,work,children',
                    'views' => 0,
                    'removed' => 0,
                    'publicationDate' => null,
                ],
                'code' => 400,
                'response' => ["errors" => ["slug" => ["VALUE_CANNOT_BE_EMPTY", "VALUE_TOO_SHORT"]]],
            ],
            'all' => [
                'body' => [
                    'createDate' => '2024',
                    'contents' => [
                        'he' => 1,
                        'she' => 1,
                    ],
                    'mainPicture' => [
                        'alt' => '',
                        'source' => '',
                    ],
                    'ready' => [
                        'he' => '',
                        'she' => '',
                    ],
                    'slug' => '',
                    'title' => '',
                    'categories' => '',
                    'views' => '',
                    'removed' => 0,
                    'publicationDate' => '2024',
                ],
                'code' => 400,
                'response' => ["errors" => [
                    "createDate" => ["INVALID_DATA"],
                    "mainPicture" => [
                        "alt" => ["VALUE_TOO_SHORT"],
                        "source" => ["VALUE_TOO_SHORT"]
                    ],
                    "publicationDate" => ["INVALID_DATA"],
                    "ready" => [
                        "he" => ["VALUE_CANNOT_BE_EMPTY"],
                        "she" => ["VALUE_CANNOT_BE_EMPTY"],
                    ],
                    "slug" => ["VALUE_CANNOT_BE_EMPTY", "VALUE_TOO_SHORT"],
                    "title" => ["VALUE_TOO_SHORT"],
                    "views" => ["VALUE_CANNOT_BE_EMPTY"],
                ]],
            ],
            'other' => [
                'body' => [
                    'createDate' => '2023-11-16T07:50',
                    'contents' => [
                        'he' => 'Jego TEST text',
                        'she' => 'Jej TEST text',
                    ],
                    'mainPicture' => [
                        'alt' => 'Dragon alt',
                        'source' => 'article/main/2024/T EST-db-duze-102',
                    ],
                    'ready' => [
                        'he' => true,
                        'she' => true,
                    ],
                    'slug' => ' ',
                    'title' => 'created-title-1',
                    'categories' => 'family,work,children',
                    'views' => 'dd',
                    'removed' => 0,
                    'publicationDate' => null,
                ],
                'code' => 400,
                'response' => ["errors" => [
                    "mainPicture" => [
                        'source' => ["INVALID_STRING_CONTAIN_WHITESPACE"]
                    ],
                    "slug" => ["INVALID_STRING_CONTAIN_WHITESPACE"],
                    "views" => ["INVALID_DATA"],
                ]],
            ],
        ];
    }

    #[DataProvider('provideExceptionsForCreateArticle')]
    public function testShouldThrowExceptionWhenCreateUser(ApiTester $I, Example $example): void
    {
        $this->adminLogin($I);

        $I->unsetHttpHeader('Content-Type');

        $I->sendPost(
            sprintf('api/admin/articles/%s', self::EXIST_UUID2),
            $example['body'],
            [
                'mainPictureFile' => codecept_data_dir('files/dragon-ball-db.jpg')
            ]
        );

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs($example['code']);
        $I->seeResponseEquals(json_encode($example['response']));
    }
}
