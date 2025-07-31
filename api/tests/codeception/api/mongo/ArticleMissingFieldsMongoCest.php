<?php
//
//declare(strict_types=1);
//
//namespace App\Tests\codeception\api\mongo;
//
//use App\Tests\codeception\api\User\UserLogin;
//use App\Tests\codeception\ApiTester;
//
//class ArticleMissingFieldsMongoCest
//{
//    use UserLogin;
//
//    private bool $initialized = false;
//
//    public function _before(ApiTester $I): void
//    {
//        if ($this->initialized) {
//            return;
//        }
//
//        $I->useDatabase($_ENV['MONGODB_DBNAME']);
//
//        $I->deleteRecordsInDatabase('articles');
//        $I->deleteRecordsInDatabase('pictures');
//        $I->deleteRecordsInDatabase('users');
//
//        $I->insertFromJsonFile('articles', 'articles-visible.json');
//        $I->insertFromJsonFile('articles', 'articles-not-visible.json');
//        $I->insertFromJsonFile('users', 'users.json');
//
//        $this->initialized = true;
//    }
//
//    public function testShouldReturnMissingFieldsWhenTryToCreateNewArticle(ApiTester $I): void
//    {
//        $this->adminLogin($I);
//
//        $I->deleteHeader('Content-Type');
//
//        $I->sendPost('api/admin/articles');
//        $I->seeResponseEquals(json_encode([
//            "errors" => [
//                "categories" => ["This field is missing."],
//                "createDate" => ["This field is missing."],
//                "contents" => ["This field is missing."],
//                "mainPictureFile" => ["This field is missing."],
//                "mainPicture" => ["This field is missing."],
//                "publicationDate" => ["This field is missing."],
//                "ready" => ["This field is missing."],
//                "removed" => ["This field is missing."],
//                "slug" => ["This field is missing."],
//                "title" => ["This field is missing."],
//                "views" => ["This field is missing."]]
//        ]));
//    }
//
//    public function testShouldReturnMissingFieldsWhenTryToUpdateArticle(ApiTester $I): void
//    {
//        $this->adminLogin($I);
//
//        $I->deleteHeader('Content-Type');
//
//        $I->sendPost('api/admin/articles/31e998ca-d0ba-4cb0-bb13-7d1f383cafe7');
//        $I->seeResponseEquals(json_encode([
//            "errors" => [
//                "categories" => ["This field is missing."],
//                "createDate" => ["This field is missing."],
//                "contents" => ["This field is missing."],
////                "mainPictureFile" => ["This field is missing."],
//                "mainPicture" => ["This field is missing."],
//                "publicationDate" => ["This field is missing."],
//                "ready" => ["This field is missing."],
//                "removed" => ["This field is missing."],
//                "slug" => ["This field is missing."],
//                "title" => ["This field is missing."],
//                "views" => ["This field is missing."],
//                "mainPictureOld" => ["This field is missing."]]
//        ]));
//    }
//}
