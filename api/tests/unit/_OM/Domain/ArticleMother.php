<?php

declare(strict_types=1);

namespace App\Tests\unit\_OM\Domain;

use App\Domain\Article\Article;
use App\Domain\Picture\Picture;
use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Domain\Shared\ValueObject\String\CategoriesVO;
use App\Domain\Shared\ValueObject\String\ContentVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Domain\Shared\ValueObject\String\TitleVO;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ArticleMother
{
    private const string DEFAULT_UUID = 'd1bb861a-d0d5-4ce5-81fa-c5d0f904f75e';
    private const string DEFAULT_CATEGORIES = 'work,couple';
    private const bool DEFAULT_READY = true;
    private const string DEFAULT_SLUG = 'DEFAULT_SLUG';
    private const string DEFAULT_TITLE = 'DEFAULT_TITLE';
    private const bool DEFAULT_REMOVED = false;

    public const string DEFAULT_DATETIME = '1994-06-30T17:40:00+00:00';

    public static function create(
        UuidInterface $uuid,
        Picture $mainPicture,
        ContentVO $contentHe,
        ContentVO $contentShe,
        bool $readyHe,
        bool $readyShe,
        SlugVO $slug,
        TitleVO $title,
        CategoriesVO $categories,
        ViewsVO $views,
        bool $removed,
        CarbonInterface $createDate,
        ?CarbonInterface $publicationDate,
    ): Article {
        return new Article(
            $uuid,
            $mainPicture,
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

    public static function createDefaultWithPicture(Picture $picture): Article
    {
        return self::create(
            Uuid::fromString(self::DEFAULT_UUID),
            $picture,
            new ContentVO(uniqid()),
            new ContentVO(uniqid()),
            self::DEFAULT_READY,
            self::DEFAULT_READY,
            new SlugVO(self::DEFAULT_SLUG),
            new TitleVO(self::DEFAULT_TITLE),
            new CategoriesVO(self::DEFAULT_CATEGORIES),
            new ViewsVO(0),
            self::DEFAULT_REMOVED,
            new Carbon(self::DEFAULT_DATETIME),
            new Carbon(self::DEFAULT_DATETIME),
        );
    }

    public static function createDefaultWithSlug(SlugVO $slug): Article
    {
        return self::create(
            Uuid::fromString(self::DEFAULT_UUID),
            PictureMother::createDefault(),
            new ContentVO(uniqid()),
            new ContentVO(uniqid()),
            self::DEFAULT_READY,
            self::DEFAULT_READY,
            $slug,
            new TitleVO(self::DEFAULT_TITLE),
            new CategoriesVO(self::DEFAULT_CATEGORIES),
            new ViewsVO(0),
            self::DEFAULT_REMOVED,
            new Carbon(self::DEFAULT_DATETIME),
            new Carbon(self::DEFAULT_DATETIME),
        );
    }

    public static function createDefaultWithViews(ViewsVO $views): Article
    {
        return self::create(
            Uuid::fromString(self::DEFAULT_UUID),
            PictureMother::createDefault(),
            new ContentVO(uniqid()),
            new ContentVO(uniqid()),
            self::DEFAULT_READY,
            self::DEFAULT_READY,
            new SlugVO(self::DEFAULT_SLUG),
            new TitleVO(self::DEFAULT_TITLE),
            new CategoriesVO(self::DEFAULT_CATEGORIES),
            $views,
            self::DEFAULT_REMOVED,
            new Carbon(self::DEFAULT_DATETIME),
            new Carbon(self::DEFAULT_DATETIME),
        );
    }

    public static function createDefault(): Article
    {
        return self::create(
            Uuid::fromString(self::DEFAULT_UUID),
            PictureMother::createDefault(),
            new ContentVO(uniqid()),
            new ContentVO(uniqid()),
            self::DEFAULT_READY,
            self::DEFAULT_READY,
            new SlugVO(self::DEFAULT_SLUG),
            new TitleVO(self::DEFAULT_TITLE),
            new CategoriesVO(self::DEFAULT_CATEGORIES),
            new ViewsVO(0),
            self::DEFAULT_REMOVED,
            new Carbon(self::DEFAULT_DATETIME),
            new Carbon(self::DEFAULT_DATETIME),
        );
    }
}
