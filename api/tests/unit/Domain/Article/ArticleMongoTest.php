<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Article;

use App\Domain\Article\ArticleMongo;
use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\Date\CreateDateVO;
use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use App\Domain\Shared\ValueObject\Iterable\CategoriesVO;
use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Domain\Shared\ValueObject\Object\ArticleReadyVO;
use App\Domain\Shared\ValueObject\Object\ContentsVO;
use App\Domain\Shared\ValueObject\Object\PictureVO;
use App\Domain\Shared\ValueObject\String\ContentVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Domain\Shared\ValueObject\String\TitleVO;
use App\Tests\unit\_OM\Domain\ArticleMother;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ArticleMongoTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $content = ['he' => uniqid(), 'she' => uniqid()];
        $mainPictureData = ['source' => uniqid(), 'alt' => uniqid(), 'extension' => PictureExtension::JPG->value];
        $ready = ['he' => true, 'she' => true];
        $slug = uniqid();
        $title = uniqid();
        $categories = [uniqid()];
        $views = random_int(1, 10);
        $removed = false;
        $createDate = ArticleMother::DEFAULT_DATETIME;
        $publicationDate = '';

        // When
        $article = $this->createInstanceUnderTest(
            $uuid,
            $content,
            $mainPictureData,
            $ready,
            $slug,
            $title,
            $categories,
            $views,
            $removed,
            $createDate,
            $publicationDate
        );

        // Then
        $this->assertSame($content, $article->contents()->toArray());
        $this->assertSame($mainPictureData['source'], $article->mainPicture()->source->__toString());
        $this->assertSame($mainPictureData['alt'], $article->mainPicture()->alt->__toString());
        $this->assertSame($mainPictureData['extension'], $article->mainPicture()->extension->value);
        $this->assertSame($ready, $article->ready()->toArray());
        $this->assertSame($slug, $article->slug()->__toString());
        $this->assertSame($title, $article->title()->__toString());
        $this->assertSame($categories, $article->categories()->toArray());
        $this->assertSame($views, $article->views()->toInteger());
        $this->assertSame($removed, $article->removed());
        $this->assertSame($createDate, $article->createDate()->toAtom());
        $this->assertSame(null, $article->publicationDate());
    }

    public function testShouldCheckIncreaseViews(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $content = ['he' => uniqid(), 'she' => uniqid()];
        $mainPictureData = ['source' => uniqid(), 'alt' => uniqid(), 'extension' => PictureExtension::JPG->value];
        $ready = ['he' => true, 'she' => true];
        $slug = uniqid();
        $title = uniqid();
        $categories = [uniqid()];
        $views = 0;
        $removed = false;
        $createDate = ArticleMother::DEFAULT_DATETIME;
        $publicationDate = '';

        // When
        $article = $this->createInstanceUnderTest(
            $uuid,
            $content,
            $mainPictureData,
            $ready,
            $slug,
            $title,
            $categories,
            $views,
            $removed,
            $createDate,
            $publicationDate
        );
        $article->increaseViews(1);

        // Then
        $this->assertSame(1, $article->views()->toInteger());
    }

    private function createInstanceUnderTest(
        UuidInterface $uuid,
        array $contents,
        array $mainPictureData,
        array $ready,
        string $slug,
        string $title,
        array $categories,
        int $views,
        bool $removed,
        string $createDate,
        string $publicationDate,
    ): ArticleMongo {
        return new ArticleMongo(
            $uuid,
            new ContentsVO(new ContentVO($contents['he']), new ContentVO($contents['she'])),
            new PictureVO($mainPictureData['source'], $mainPictureData['alt'], $mainPictureData['extension']),
            new ArticleReadyVO((bool)$ready['she'], (bool)$ready['he']),
            new SlugVO($slug),
            new TitleVO($title),
            new CategoriesVO($categories),
            new ViewsVO($views),
            $removed,
            new CreateDateVO($createDate),
            '' !== $publicationDate ? new PublicationDateVO($publicationDate) : null
        );
    }
}
