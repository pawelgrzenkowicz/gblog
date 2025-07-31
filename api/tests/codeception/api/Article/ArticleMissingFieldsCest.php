<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\Article;

use App\Tests\codeception\api\User\UserLogin;
use App\Tests\codeception\ApiTester;

class ArticleMissingFieldsCest
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

        $I->loadSqlFile('dev.pictures.pictures_insert.sql');
        $I->loadSqlFile('dev.articles.articles_visible_insert.sql');
        $I->loadSqlFile('dev.articles.articles_not_visible_insert.sql');
        $I->loadSqlFile('dev.users.users_insert.sql');

        $this->initialized = true;
    }

    public function testShouldReturnMissingFieldsWhenTryToCreateNewArticle(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->unsetHttpHeader('Content-Type');

        $I->sendPost('api/admin/articles');
        $I->seeResponseEquals(json_encode([
            "errors" => [
                "categories" => ["This field is missing."],
                "createDate" => ["This field is missing."],
                "contents" => ["This field is missing."],
                "mainPictureFile" => ["This field is missing."],
                "mainPicture" => ["This field is missing."],
                "publicationDate" => ["This field is missing."],
                "ready" => ["This field is missing."],
                "removed" => ["This field is missing."],
                "slug" => ["This field is missing."],
                "title" => ["This field is missing."],
                "views" => ["This field is missing."]]
        ]));
    }

    public function testShouldReturnMissingFieldsWhenTryToUpdateArticle(ApiTester $I): void
    {
        $this->adminLogin($I);

        $I->unsetHttpHeader('Content-Type');

        $I->sendPost('api/admin/articles/31e998ca-d0ba-4cb0-bb13-7d1f383cafe7');
        $I->seeResponseEquals(json_encode([
            "errors" => [
                "categories" => ["This field is missing."],
                "createDate" => ["This field is missing."],
                "contents" => ["This field is missing."],
//                "mainPictureFile" => ["This field is missing."],
                "mainPicture" => ["This field is missing."],
                "publicationDate" => ["This field is missing."],
                "ready" => ["This field is missing."],
                "removed" => ["This field is missing."],
                "slug" => ["This field is missing."],
                "title" => ["This field is missing."],
                "views" => ["This field is missing."]]
        ]));
    }
}
