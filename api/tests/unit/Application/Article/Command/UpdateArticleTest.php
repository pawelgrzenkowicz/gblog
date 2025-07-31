<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Command;

use App\Application\Article\Command\UpdateArticle;
use App\Domain\Shared\Enum\PictureExtension;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use SplFileInfo;

class UpdateArticleTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $actual = $this->createInstanceUnderTest(
            $uuid = Uuid::uuid4()->toString(),
            $file = new SplFileInfo(__DIR__ . '/../../../../../public/core/dragon-ball-db.jpg'),
            $mainPictureSource = uniqid(),
            $mainPictureAlt = uniqid(),
            $contentHe = uniqid(),
            $contentShe = uniqid(),
            $readyHe = true,
            $readyShe = true,
            $slug = uniqid(),
            $title = uniqid(),
            $categories = uniqid(),
            $views = 0,
            $removed = true,
            $createDate = '1994-06-30T17:40:00+00:00',
            $publicationDate = '1994-06-30T17:40'
        );

        // Then
        $this->assertEquals($uuid, $actual->uuid->toString());
        $this->assertEquals($file, $actual->picture);
        $this->assertEquals($contentHe, $actual->contentHe->value);
        $this->assertEquals($contentShe, $actual->contentShe->value);
        $this->assertSame($mainPictureSource, $actual->source->__toString());
        $this->assertSame($mainPictureAlt, $actual->alt->__toString());
        $this->assertEquals($readyHe, $actual->readyHe);
        $this->assertEquals($readyShe, $actual->readyShe);
        $this->assertEquals($slug, $actual->slug->__toString());
        $this->assertEquals($title, $actual->title->__toString());
        $this->assertEquals($categories, $actual->categories->value);
        $this->assertEquals($views, $actual->views->toInteger());
        $this->assertEquals($removed, $actual->removed);
        $this->assertEquals(new Carbon($createDate), $actual->createDate);
        $this->assertEquals(new Carbon($publicationDate), $actual->publicationDate);
    }

    private function createInstanceUnderTest(
        string $uuid,
        ?SplFileInfo $picture,
        string $source,
        string $alt,
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
        string $publicationDate
    ): UpdateArticle {
        return new UpdateArticle(
            $uuid,
            $picture,
            $source,
            $alt,
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
