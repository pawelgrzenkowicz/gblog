<?php

declare(strict_types=1);

namespace App\Tests\codeception\functional\Infrastructure\Article\Reader;

use App\Application\Article\Reader\VisibleArticleReader;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Infrastructure\Article\Reader\VisibleArticleSqlReader;
use App\Tests\codeception\api\Article\ArticleResponseReader;
use App\Tests\codeception\FunctionalTester;
use App\Tests\unit\_OM\Application\Article\View\VisibleArticleViewMother;
use Codeception\Attribute\DataProvider;
use Codeception\Example;

class VisibleArticleSqlReaderCest
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

    private function provideParamsForGetAllVisibleArticles(): array
    {
        $response = $this->getArticleList('article-visible-list.json');

        return [
            [
                'page' => 1,
                'limit' => 3,
                'response' => [
                    VisibleArticleViewMother::create(...$response[0]),
                    VisibleArticleViewMother::create(...$response[1]),
                    VisibleArticleViewMother::create(...$response[2]),
                ],
            ],
            [
                'page' => 2,
                'limit' => 4,
                'response' => [
                    VisibleArticleViewMother::create(...$response[4]),
                    VisibleArticleViewMother::create(...$response[5]),
                    VisibleArticleViewMother::create(...$response[6]),
                    VisibleArticleViewMother::create(...$response[7]),
                ],
            ],
            [
                'page' => 2,
                'limit' => 10,
                'response' => [
                    VisibleArticleViewMother::create(...$response[10]),
                ],
            ],
        ];
    }

    #[DataProvider('provideParamsForGetAllVisibleArticles')]
    public function testShouldReturnVisibleArticlesWithParams(FunctionalTester $I, Example $example): void
    {
        // When
        /** @var VisibleArticleReader $reader */
        $reader = $I->getClass(VisibleArticleSqlReader::class);
        $articles = $reader->all(
            new Pagination($example['page'], $example['limit']),
            new Sort('publication_date', 'desc')
        );

        // Then
        $I->assertEquals($articles, $example['response']);
    }

    public function testShouldReturnArticleView(FunctionalTester $I): void
    {
        // Given
        $expected = VisibleArticleViewMother::create(...$this->getArticleList('article-visible-list.json')[9]);

        // When
        /** @var VisibleArticleReader $reader */
        $reader = $I->getClass(VisibleArticleSqlReader::class);
        $article = $reader->bySlug(new SlugVO(self::EXIST_SLUG));

        // Then
        $I->assertEquals($expected, $article);
    }

    public function testShouldCountArticles(FunctionalTester $I): void
    {
        // When
        /** @var VisibleArticleReader $reader */
        $reader = $I->getClass(VisibleArticleSqlReader::class);
        $count = $reader->count();

        // Then
        $I->assertEquals(11, $count);
    }

    private function provideNotVisibleArticleSlug(): array
    {
        return [
            'publication is in future' => [
                'slug' => 'test-slug-04',
            ],
            'publication is null' => [
                'slug' => 'test-slug-05',
            ],
            'removed true' => [
                'slug' => 'test-slug-03',
            ],
            'he not ready' => [
                'slug' => 'test-slug-01',
            ],
            'she not ready' => [
                'slug' => 'test-slug-02',
            ],
        ];
    }

    #[DataProvider('provideNotVisibleArticleSlug')]
    public function testShouldReturnNullWhenArticleNotFound(FunctionalTester $I, Example $example): void
    {
        // When
        /** @var VisibleArticleReader $reader */
        $reader = $I->getClass(VisibleArticleSqlReader::class);
        $article = $reader->bySlug(new SlugVO($example['slug']));

        // Then
        $I->assertNull($article);
    }
}
