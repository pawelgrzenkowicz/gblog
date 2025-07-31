<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Article;

use App\Domain\Article\Article;
use App\Domain\Picture\Picture;
use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Domain\Shared\ValueObject\String\CategoriesVO;
use App\Domain\Shared\ValueObject\String\ContentVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Domain\Shared\ValueObject\String\TitleVO;
use App\Tests\unit\_OM\Domain\ArticleMother;
use App\Tests\unit\_OM\Domain\PictureMother;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ArticleTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $picture = PictureMother::createDefault();
        $contentHe = uniqid();
        $contentShe = uniqid();
        $readyHe = true;
        $readyShe = true;
        $slug = uniqid();
        $title = uniqid();
        $categories = uniqid();
        $views = random_int(1, 10);
        $removed = false;
        $createDate = ArticleMother::DEFAULT_DATETIME;
        $publicationDate = '';

        // When
        $article = $this->createInstanceUnderTest(
            $uuid,
            $picture,
            $contentHe,
            $contentShe,
            $readyHe,
            $readyShe,
            $slug,
            $title,
            $categories,
            $views,
            $removed,
            $createDate,
            $publicationDate
        );

        // Then
        $this->assertSame($picture, $article->mainPicture());
        $this->assertSame($contentHe, $article->contentHe()->value);
        $this->assertSame($contentShe, $article->contentShe()->value);
        $this->assertSame($readyHe, $article->readyHe());
        $this->assertSame($readyShe, $article->readyShe());
        $this->assertSame($slug, $article->slug()->__toString());
        $this->assertSame($title, $article->title()->__toString());
        $this->assertSame($categories, $article->categories()->value);
        $this->assertSame($views, $article->views()->toInteger());
        $this->assertSame($removed, $article->removed());
        $this->assertEquals(new Carbon($createDate), $article->createDate());
        $this->assertSame(null, $article->publicationDate());
        $this->assertSame($createDate, $article->createDateToAtom());
        $this->assertSame('', $article->publicationDateFormatted());
    }

    public function testShouldReturnValidFormattedPublicationDate(): void
    {
        // When
        $article = ArticleMother::createDefault();

        // Then
        $this->assertSame('1994-06-30T17:40', $article->publicationDateFormatted());
    }

    public function testShouldCheckIncreaseViews(): void
    {
        // When
        $article = ArticleMother::createDefault();
        $article->increaseViews(1);

        // Then
        $this->assertSame(1, $article->views()->toInteger());
    }

    private function createInstanceUnderTest(
        UuidInterface $uuid,
        Picture $picture,
        string $contentHe,
        string $contentShe,
        bool $readyHe,
        bool $readyShe,
        string $slug,
        string $title,
        string $categories,
        int $views,
        bool $removed,
        string $createDate,
        string $publicationDate,
    ): Article {
        return ArticleMother::create(
            $uuid,
            $picture,
            new ContentVO($contentHe),
            new ContentVO($contentShe),
            $readyHe,
            $readyShe,
            new SlugVO($slug),
            new TitleVO($title),
            new CategoriesVO($categories),
            new ViewsVO($views),
            $removed,
            new Carbon($createDate),
            '' !== $publicationDate ? new Carbon($publicationDate) : null
        );
    }
}
