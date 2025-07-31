<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\Application\Article\View;

use App\Application\Article\View\VisibleArticleView;

class VisibleArticleViewMother
{
    private const string DEFAULT_UUID = '64fc0c67-8c0f-4677-8e73-27320a2f2f59';
    private const string DEFAULT_ALT = 'DEFAULT_ALT';
    private const string DEFAULT_CATEGORIES = 'DEFAULT_CATEGORY';
    private const string DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';
    private const string DEFAULT_SLUG = 'DEFAULT_SLUG';
    private const string DEFAULT_TITLE = 'DEFAULT_TITLE';
    private const int DEFAULT_VIEWS = 0;

    public static function create(
        string $uuid,
        array $contents,
        array $mainPicture,
        string $slug,
        string $title,
        int $views,
        string $categories,
        ?string $publicationDate,
    ): VisibleArticleView {
        return new VisibleArticleView(
            $uuid,
            $contents,
            $mainPicture,
            $slug,
            $title,
            $views,
            $categories,
            $publicationDate,
        );
    }

    public static function createDefault(): VisibleArticleView
    {
        return self::create(
            self::DEFAULT_UUID,
            ['she' => 'she', 'he' => 'he'],
            ['source' => 'article/main/dummy-obrazek-test-1705485869.png', 'alt' => self::DEFAULT_ALT],
            self::DEFAULT_SLUG,
            self::DEFAULT_TITLE,
            self::DEFAULT_VIEWS,
            self::DEFAULT_CATEGORIES,
            self::DEFAULT_DATETIME,
        );
    }
}
