<?php

declare(strict_types=1);

namespace App\Tests\codeception\functional\Infrastructure\Article\Reader;

use App\Application\Article\Reader\AdminArticleDetailsReader;
use App\Application\Article\View\AdminArticleDetailsView;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Infrastructure\Article\Reader\AdminArticlesDetailsSqlReader;
use App\Tests\codeception\api\Article\ArticleResponseReader;
use App\Tests\codeception\FunctionalTester;
use App\Tests\unit\_OM\Application\Article\View\AdminArticleDetailsViewMother;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Ramsey\Uuid\Uuid;

class AdminArticlesDetailsSqlReaderCest
{
    private const string EXIST_SLUG = 'test-slug-1';
    private const string EXIST_UUID = '61d445c0-6a30-4b52-885c-1b26bfaae578';
    private const string NOT_EXIST_SLUG = 'NO_EXIST_SLUG';

    use ArticleResponseReader;

    private bool $initialized = false;

    public function _before(FunctionalTester $I): void
    {
        if ($this->initialized) {
            return;
        }

        $I->clearDb('pictures');
        $I->clearDb('articles');

        $I->loadSqlFile('dev.pictures.pictures_insert.sql');
        $I->loadSqlFile('dev.articles.articles_visible_insert.sql');
        $I->loadSqlFile('dev.articles.articles_not_visible_insert.sql');

        $this->initialized = true;
    }

    public function testShouldGetArticleBySlug(FunctionalTester $I): void
    {
        // Given
        $expected = AdminArticleDetailsViewMother::create(
            self::EXIST_UUID,
            ['he' => 'jego text', 'she' => 'jej text'],
            '1994-06-30T17:40:00+00:00',
            ['alt' => 'Dragon-alt', 'extension' => 'jpg', 'source' => 'some/path/command-dragon-ball-db.jpg'],
            self::EXIST_SLUG,
            'test-tytuł-1',
            'rodzina,malzenstwo',
            '2004-06-30T17:40:00+00:00',
            ['he' => true, 'she' => true],
            false,
            0,
            'command-dragon-ball-db',
            '2004-06-30T17:40'
        );

        // When
        /** @var AdminArticleDetailsReader $reader */
        $reader = $I->getClass(AdminArticlesDetailsSqlReader::class);
        $article = $reader->bySlug(new SlugVO(self::EXIST_SLUG));

        // Then
        $I->assertEquals($expected, $article);
    }

    public function testShouldGetArticleByUuid(FunctionalTester $I): void
    {
        // Given
        $expected = AdminArticleDetailsViewMother::create(
            self::EXIST_UUID,
            ['he' => 'jego text', 'she' => 'jej text'],
            '1994-06-30T17:40:00+00:00',
            ['alt' => 'Dragon-alt', 'extension' => 'jpg', 'source' => 'some/path/command-dragon-ball-db.jpg'],
            self::EXIST_SLUG,
            'test-tytuł-1',
            'rodzina,malzenstwo',
            '2004-06-30T17:40:00+00:00',
            ['he' => true, 'she' => true],
            false,
            0,
            'command-dragon-ball-db',
            '2004-06-30T17:40'
        );

        // When
        /** @var AdminArticleDetailsReader $reader */
        $reader = $I->getClass(AdminArticlesDetailsSqlReader::class);
        $article = $reader->byUuid(Uuid::fromString(self::EXIST_UUID));

        // Then
        $I->assertEquals($expected, $article);
    }

    private function provideParamsForGetAdminArticles(): array
    {
        $response = $this->getArticleList('admin-articles.json');
        return [
            [
                'page' => 1,
                'limit' => 3,
                'response' => [
                    new AdminArticleDetailsView(...$response[0]),
                    new AdminArticleDetailsView(...$response[1]),
                    new AdminArticleDetailsView(...$response[2]),
                ],
            ],
            [
                'page' => 2,
                'limit' => 4,
                'response' => [
                    new AdminArticleDetailsView(...$response[4]),
                    new AdminArticleDetailsView(...$response[5]),
                    new AdminArticleDetailsView(...$response[6]),
                    new AdminArticleDetailsView(...$response[7]),
                ],
            ],
            [
                'page' => 2,
                'limit' => 10,
                'response' => [
                    new AdminArticleDetailsView(...$response[10]),
                    new AdminArticleDetailsView(...$response[11]),
                    new AdminArticleDetailsView(...$response[12]),
                    new AdminArticleDetailsView(...$response[13]),
                    new AdminArticleDetailsView(...$response[14]),
                    new AdminArticleDetailsView(...$response[15]),
                ],
            ],
        ];
    }

    #[DataProvider('provideParamsForGetAdminArticles')]
    public function testShouldReturnAdminArticlesWithParams(FunctionalTester $I, Example $example): void
    {
        // When
        /** @var AdminArticleDetailsReader $reader */
        $reader = $I->getClass(AdminArticlesDetailsSqlReader::class);
        $articles = $reader->all(
            new Pagination($example['page'], $example['limit']),
            new Sort('publication_date', 'desc')
        );

        // Then
        $I->assertEquals($articles, $example['response']);
    }

    public function testShouldCountArticles(FunctionalTester $I): void
    {
        // When
        /** @var AdminArticleDetailsReader $reader */
        $reader = $I->getClass(AdminArticlesDetailsSqlReader::class);
        $count = $reader->count();

        // Then
        $I->assertEquals(16, $count);
    }

    public function testShouldReturnNullWhenArticleNotFound(FunctionalTester $I): void
    {
        // When
        /** @var AdminArticleDetailsReader $reader */
        $reader = $I->getClass(AdminArticlesDetailsSqlReader::class);
        $article = $reader->bySlug(new SlugVO(self::NOT_EXIST_SLUG));

        // Then
        $I->assertNull($article);
    }
}
