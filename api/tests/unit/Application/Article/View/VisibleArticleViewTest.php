<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\View;

use App\Application\Article\View\VisibleArticleView;
use Codeception\PHPUnit\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Ramsey\Uuid\Uuid;

class VisibleArticleViewTest extends TestCase
{
    static public function provideData(): array
    {
        return [
            [
                'uuid' => Uuid::uuid4()->toString(),
                'contents' => ['he' => uniqid(), 'she' => uniqid()],
                'mainPicture' => [
                    'alt' => uniqid(),
                    'extension' => uniqid(),
                    'source' => uniqid()
                ],
                'slug' => uniqid(),
                'title' => uniqid(),
                'views' => rand(0, 199),
                'categories' => uniqid(),
                'publicationDate' => '2005-06-30T17:40',
            ],
            [
                'uuid' => Uuid::uuid4()->toString(),
                'contents' => ['he' => uniqid(), 'she' => uniqid()],
                'mainPicture' => [''],
                'slug' => uniqid(),
                'title' => uniqid(),
                'views' => rand(0, 199),
                'categories' => uniqid(),
                'publicationDate' => null,
            ],
        ];
    }

    #[DataProvider('provideData')]
    public function testShouldCreateValidObject(
        string $uuid,
        array $contents,
        array $mainPicture,
        string $slug,
        string $title,
        int $views,
        string $categories,
        ?string $publicationDate
    ): void {
        // Given

        // When
        $view = $this->createInstanceUnderTest(
            $uuid,
            $contents,
            $mainPicture,
            $slug,
            $title,
            $views,
            $categories,
            $publicationDate
        );

        // Then
        $this->assertEquals($uuid, $view->uuid);
        $this->assertEquals($contents, $view->contents);
        $this->assertEquals($mainPicture, $view->mainPicture);
        $this->assertEquals($slug, $view->slug);
        $this->assertEquals($title, $view->title);
        $this->assertEquals($views, $view->views);
        $this->assertEquals($categories, $view->categories);
        $this->assertEquals($publicationDate, $view->publicationDate);
    }

    private function createInstanceUnderTest(
        string $uuid,
        array $contents,
        array $mainPicture,
        string $slug,
        string $title,
        int $views,
        string $categories,
        ?string $publicationDate
    ): VisibleArticleView
    {
        return new VisibleArticleView(
            $uuid,
            $contents,
            $mainPicture,
            $slug,
            $title,
            $views,
            $categories,
            $publicationDate
        );
    }
}
