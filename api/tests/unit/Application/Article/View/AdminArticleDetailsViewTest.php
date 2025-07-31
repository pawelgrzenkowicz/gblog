<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\View;

use App\Application\Article\View\AdminArticleDetailsView;
use Codeception\PHPUnit\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Ramsey\Uuid\Uuid;

class AdminArticleDetailsViewTest extends TestCase
{
    static public function provideData(): array
    {
        return [
            [
                'uuid' => Uuid::uuid4()->toString(),
                'contents' => ['he' => uniqid(), 'she' => uniqid()],
                'createDate' => '1994-06-30T17:40',
                'mainPicture' => [
                    'alt' => uniqid(),
                    'extension' => uniqid(),
                    'source' => uniqid()
                ],
                'slug' => uniqid(),
                'title' => uniqid(),
                'categories' => uniqid(),
                'publicationDate' => '2005-06-30T17:40:00+00:00',
                'ready' => ['he' => true, 'she' => true],
                'removed' => true,
                'views' => rand(0, 199),
                'mainPictureName' => uniqid(),
                'publicationDateFormatted' => '2005-06-30T17:40',
            ],
           [
                'uuid' => Uuid::uuid4()->toString(),
                'contents' => ['he' => uniqid(), 'she' => uniqid()],
                'createDate' => '1994-06-30T17:40',
                'mainPicture' => [
                    'alt' => uniqid(),
                    'extension' => uniqid(),
                    'source' => uniqid()
                ],
                'slug' => uniqid(),
                'title' => uniqid(),
                'categories' => uniqid(),
                'publicationDate' => null,
                'ready' => ['he' => false, 'she' => false],
                'removed' => false,
                'views' => rand(0, 199),
                'mainPictureName' => uniqid(),
                'publicationDateFormatted' => null,
            ],
        ];
    }

    #[DataProvider('provideData')]
    public function testShouldCreateValidObject(
        string $uuid,
        array $contents,
        string $createDate,
        array $mainPicture,
        string $slug,
        string $title,
        string $categories,
        ?string $publicationDate,
        array $ready,
        bool $removed,
        int $views,
        string $mainPictureName,
        ?string $publicationDateFormatted,
    ): void {
        // Given

        // When
        $view = $this->createInstanceUnderTest(
            $uuid,
            $contents,
            $createDate,
            $mainPicture,
            $slug,
            $title,
            $categories,
            $publicationDate,
            $ready,
            $removed,
            $views,
            $mainPictureName,
            $publicationDateFormatted
        );

        // Then
        $this->assertEquals($uuid, $view->uuid);
        $this->assertEquals($contents, $view->contents);
        $this->assertEquals($createDate, $view->createDate);
        $this->assertEquals($mainPicture, $view->mainPicture);
        $this->assertEquals($slug, $view->slug);
        $this->assertEquals($title, $view->title);
        $this->assertEquals($categories, $view->categories);
        $this->assertEquals($publicationDate, $view->publicationDate);
        $this->assertEquals($ready, $view->ready);
        $this->assertEquals($removed, $view->removed);
        $this->assertEquals($views, $view->views);
        $this->assertEquals($mainPictureName, $view->mainPictureName);
        $this->assertEquals($publicationDateFormatted, $view->publicationDateFormatted);
    }

    private function createInstanceUnderTest(
        string $uuid,
        array $contents,
        string $createDate,
        array $mainPicture,
        string $slug,
        string $title,
        string $categories,
        ?string $publicationDate,
        array $ready,
        bool $removed,
        int $views,
        string $mainPictureName,
        ?string $publicationDateFormatted,
    ): AdminArticleDetailsView
    {
        return new AdminArticleDetailsView(
            $uuid,
            $contents,
            $createDate,
            $mainPicture,
            $slug,
            $title,
            $categories,
            $publicationDate,
            $ready,
            $removed,
            $views,
            $mainPictureName,
            $publicationDateFormatted
        );
    }
}
