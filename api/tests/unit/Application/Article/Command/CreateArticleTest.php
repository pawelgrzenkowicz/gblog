<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Command;

use App\Application\Article\Command\CreateArticle;
use App\Domain\Picture\Picture;
use App\Tests\unit\_OM\Domain\PictureMother;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CreateArticleTest extends TestCase
{
    private const string DEFAULT_DATE = '1994-06-30T17:40:00+00:00';

    public static function provideArticles(): array
    {
        return [
            [
                'contentHe' => 'he',
                'contentShe' => 'she',
                'picture' => PictureMother::createDefault(),
                'readyHe' => true,
                'readyShe' => true,
                'slug' => 'DEFAULT_SLUG',
                'title' => 'DEFAULT_TITLE',
                'categories' => 'word,couple',
                'views' => 0,
                'removed' => false,
                'createDate' => self::DEFAULT_DATE,
                'publicationDate' => self::DEFAULT_DATE,
            ],
        ];
    }


    #[DataProvider('provideArticles')]
    public function testShouldCreateValidObject(
        string $contentHe,
        string $contentShe,
        Picture $picture,
        bool $readyHe,
        bool $readyShe,
        string $slug,
        string $title,
        string $categories,
        int $views,
        bool $removed,
        string $createDate,
        ?string $publicationDate
    ): void {

        // When
        $article = $this->createInstanceUnderTest(
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
        $this->assertSame($picture, $article->picture);
        $this->assertSame($contentHe, $article->contentHe->value);
        $this->assertSame($contentShe, $article->contentShe->value);
        $this->assertSame(true, $article->readyHe);
        $this->assertSame(true, $article->readyShe);
        $this->assertSame($slug, $article->slug->value);
        $this->assertSame($title, $article->title->value);
        $this->assertSame($categories, $article->categories->value);
        $this->assertSame($removed, $article->removed);
        $this->assertEquals(new Carbon($createDate), $article->createDate);
        $this->assertEquals(new Carbon($publicationDate), $article->publicationDate);
        $this->assertSame($views, $article->views->value);
    }

    private function createInstanceUnderTest(
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
        ?string $publicationDate
    ) :CreateArticle {
        return new CreateArticle(
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
    }
}
