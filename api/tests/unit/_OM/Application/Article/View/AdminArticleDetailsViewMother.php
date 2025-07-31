<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\Application\Article\View;

use App\Application\Article\View\AdminArticleDetailsView;
use App\Domain\Shared\Enum\PictureExtension;

class AdminArticleDetailsViewMother
{
    private const string DEFAULT_UUID = '64fc0c67-8c0f-4677-8e73-27320a2f2f59';
    private const string DEFAULT_ALT = 'DEFAULT_ALT';
    private const string DEFAULT_CATEGORIES = 'family,couple';
    private const string DEFAULT_CATEGORIES_STRING = 'family,couple';
    private const string DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';
    private const string DEFAULT_FORMATTED_DATETIME = '1994-06-30T17:40';
    private const bool DEFAULT_READY = true;
    private const bool DEFAULT_REMOVED = false;
    private const string DEFAULT_SLUG = 'DEFAULT_SLUG';
    private const string DEFAULT_TITLE = 'DEFAULT_TITLE';

    public static function create(
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
//        string $categoriesText,
        ?string $publicationDateFormatted,
    ): AdminArticleDetailsView {
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
//            $categoriesText,
            $publicationDateFormatted,
        );
    }

    public static function createDefault(): AdminArticleDetailsView
    {
        return self::create(
            self::DEFAULT_UUID,
            ['she' => 'she', 'he' => 'he'],
            self::DEFAULT_DATETIME,
            [ 'alt' => self::DEFAULT_ALT, 'extension' => PictureExtension::JPG->value, 'source' => 'article/main/dummy-obrazek-test-1705485869.png',],
            self::DEFAULT_SLUG,
            self::DEFAULT_TITLE,
            self::DEFAULT_CATEGORIES,
            self::DEFAULT_DATETIME,
            ['she' => self::DEFAULT_READY, 'he' => self::DEFAULT_READY],
            self::DEFAULT_REMOVED,
            0,
            'dummy-obrazek-test-1705485869.png',
            self::DEFAULT_CATEGORIES_STRING,
            self::DEFAULT_FORMATTED_DATETIME
        );
    }
}
