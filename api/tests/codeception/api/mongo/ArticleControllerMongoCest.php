<?php
//
//declare(strict_types=1);
//
//namespace App\Tests\codeception\api\Article;
//
//use App\Tests\codeception\ApiTester;
//use Codeception\Attribute\DataProvider;
//use Codeception\Example;
//use Codeception\Util\HttpCode;
//
//class ArticleControllerMongoCest
//{
//    private const string EXIST_SLUG = 'test-slug-1';
//
//    use ArticleResponseReader;
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
//
//        $I->insertFromJsonFile('articles', 'articles-visible.json');
//
//        $this->initialized = true;
//    }
//
//    # GET #
//
//    private function provideExceptionsForGetArticlesBySlug(): array
//    {
//        return [
//            [
//                'slug' => 'no_exist_slug',
//                'response' => ["type" => "ARTICLE_NOT_FOUND"],
//                'code' => 404,
//            ],
//        ];
//    }
//
//    #[DataProvider('provideExceptionsForGetArticlesBySlug')]
//    public function testShouldThrowExceptionWhenGetArticlesBySlug(ApiTester $I, Example $example): void
//    {
//        $I->sendGet(sprintf('api/articles/%s', $example['slug']));
//        $I->haveHttpHeader('Content-Type', 'application/json');
//        $I->seeResponseCodeIs($example['code']);
//        $I->seeResponseContains(json_encode($example['response']));
//    }
//
//    public function testShouldReturnVisibleArticlesWithoutParams(ApiTester $I): void
//    {
//        $I->sendGet('api/visible/articles');
//
//        $I->haveHttpHeader('Content-Type', 'application/json');
//        $I->seeResponseCodeIs(HttpCode::OK);
//        $I->seeResponseEquals(json_encode([
//            "items" => array_slice($this->getArticleList('article-visible-list.json'), 0, 10),
//            "page" => 1,
//            "total" => 11
//        ]));
//    }
//
//    private function provideParamsForGetVisibleArticles(): array
//    {
//        $response = $this->getArticleList('article-visible-list.json');
//        return [
//            [
//                'params' => 'page=1&limit=3',
//                'response' => ["items" => array_slice($response, 0, 3), "page" => 1, "total" => 11],
//            ],
//            [
//                'params' => 'page=2&limit=4',
//                'response' => ["items" => array_slice($response, 4, 4), "page" => 2, "total" => 11],
//            ],
//            [
//                'params' => 'page=2&limit=10',
//                'response' => ["items" => array_slice($response, 10, 1), "page" => 2, "total" => 11],
//            ],
//        ];
//    }
//
//    #[DataProvider('provideParamsForGetVisibleArticles')]
//    public function testShouldReturnVisibleArticlesWithParams(ApiTester $I, Example $example): void
//    {
//        $I->sendGet(sprintf('api/visible/articles?%s', $example['params']));
//        $I->haveHttpHeader('Content-Type', 'application/json');
//        $I->seeResponseCodeIs(HttpCode::OK);
//        $I->seeResponseEquals(json_encode($example['response']));
//    }
//
//    public function testShouldReturnArticleBySlug(ApiTester $I): void
//    {
//        $I->sendGet(sprintf('api/articles/%s', self::EXIST_SLUG));
//        $I->haveHttpHeader('Content-Type', 'application/json');
//        $I->seeResponseCodeIs(HttpCode::OK);
//        $I->seeResponseEquals(json_encode($this->getArticleList('article-by-slug.json')[0]));
//    }
//}
