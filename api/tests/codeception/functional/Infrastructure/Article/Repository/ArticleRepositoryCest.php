<?php

namespace App\Tests\codeception\functional\Infrastructure\Article\Repository;

use App\Domain\Article\Article;
use App\Domain\Article\ArticleRepositoryInterface;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Infrastructure\Article\Repository\ArticleRepository;
use App\Tests\codeception\FunctionalTester;
use Ramsey\Uuid\Uuid;

class ArticleRepositoryCest
{
    private const string EXIST_SLUG = 'test-slug-1';
    private const string EXIST_UUID = '61d445c0-6a30-4b52-885c-1b26bfaae578';
    private const string NOT_EXIST_UUID = 'cd6014ca-5c3e-4a0d-a8ba-24b0d3be9c96';

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

        $this->initialized = true;
    }

    public function testShouldGetArticleByUuid(FunctionalTester $I): void
    {
        // When
        /** @var ArticleRepositoryInterface $repo */
        $repo = $I->getClass(ArticleRepository::class);
        $article = $repo->byUuid(Uuid::fromString(self::EXIST_UUID));

        // Then
        $this->assertArticle($I, $article);
    }

    public function testShouldGetArticleBySlug(FunctionalTester $I): void
    {
        // When
        /** @var ArticleRepositoryInterface $repo */
        $repo = $I->getClass(ArticleRepository::class);
        $article = $repo->bySlug(new SlugVO(self::EXIST_SLUG));

        // Then
        $this->assertArticle($I, $article);
    }

    public function testShouldReturnNullWhenArticleNotFound(FunctionalTester $I): void
    {
        // Given
        /** @var ArticleRepositoryInterface $repo */
        $repo = $I->getClass(ArticleRepository::class);

        // When
        $article = $repo->byUuid(Uuid::fromString(self::NOT_EXIST_UUID));

        // Then
        $I->assertNull($article);
    }

    # DELETE #

    public function testShouldSoftDeleteArticle(FunctionalTester $I): void
    {
        // When
        /** @var ArticleRepositoryInterface $repo */
        $repo = $I->getClass(ArticleRepository::class);
        $article = $repo->byUuid(Uuid::fromString(self::EXIST_UUID));

        $repo->delete($article);

//        $collection = $I->grabFromCollection('articles', ['_id' => self::EXIST_UUID]);
        $entry = $I->grabEntryFromDatabase('articles', ['uuid' => self::EXIST_UUID]);

        // Then
        $I->assertSame(1, $entry['removed']);
    }

    public function testShouldSoftUnDeleteArticle(FunctionalTester $I): void
    {
        // When
        /** @var ArticleRepositoryInterface $repo */
        $repo = $I->getClass(ArticleRepository::class);
        $article = $repo->byUuid(Uuid::fromString(self::EXIST_UUID));

        $repo->undelete($article);

//        $collection = $I->grabFromCollection('articles', ['_id' => self::EXIST_UUID]);
        $entry = $I->grabEntryFromDatabase('articles', ['uuid' => self::EXIST_UUID]);

        // Then
        $I->assertSame(0, $entry['removed']);
    }

    private function assertArticle(FunctionalTester $I, Article $article): void
    {
        $I->assertNotEmpty($article);
        $I->assertSame(self::EXIST_UUID, $article->uuid->toString());
//        $I->assertSame(['rodzina', 'malzenstwo'], $article->categories()->toArray());
        $I->assertSame('rodzina,malzenstwo', $article->categories()->__toString());
        $I->assertSame('jego text', $article->contentHe()->__toString());
        $I->assertSame('jej text', $article->contentShe()->__toString());
        $I->assertSame('1994-06-30T17:40:00+00:00', $article->createDate()->toAtomString());
        $I->assertSame('1994-06-30T17:40:00+00:00', $article->createDateToAtom());
        $I->assertSame('6c250e3f-a172-4322-9551-87f7d0713df9', $article->mainPicture()->uuid->toString());
        $I->assertSame(
            ['alt' => 'Dragon-alt', 'extension' => 'jpg', 'source' => 'some/path/command-dragon-ball-db.jpg'],
            $article->mainPicture()->toArray()
        );
//        dump($article->mainPicture()->toArray());
        $I->assertSame('2004-06-30T17:40', $article->publicationDateFormatted());
//        $I->assertSame(['he' => true, 'she' => true], $article->ready()->toArray());
        $I->assertSame(true, $article->readyHe());
        $I->assertSame(true, $article->readyShe());
        $I->assertFalse($article->removed());
        $I->assertSame('test-slug-1', $article->slug()->__toString());
        $I->assertSame('test-tytuł-1', $article->title()->__toString());
        $I->assertSame(0, $article->views()->toInteger());
    }
}
