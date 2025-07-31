<?php

declare(strict_types=1);

namespace App\Application\Article\Command;

use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Domain\Shared\ValueObject\String\CategoriesVO;
use App\Domain\Shared\ValueObject\String\ContentVO;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Domain\Shared\ValueObject\String\TitleVO;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use SplFileInfo;


class UpdateArticle
{
    public UuidInterface $uuid;

    public CategoriesVO $categories;

    public ContentVO $contentHe;
    public ContentVO $contentShe;

    public ?SplFileInfo $picture;
    public PictureAltVO $alt;
    public PictureSourceVO $source;
    public PictureSourceVO $oldSource;

    public bool $readyHe;
    public bool $readyShe;

    public SlugVO $slug;

    public TitleVO $title;

    public ViewsVO $views;

    public bool $removed;

    public CarbonInterface $createDate;

    public ?CarbonInterface $publicationDate;

    public function __construct(
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
    ) {
        $this->uuid = Uuid::fromString($uuid);
        $this->picture = $picture;
        $this->source = new PictureSourceVO($source);
        $this->alt = new PictureAltVO($alt);
        $this->contentHe = new ContentVO($contentHe);
        $this->contentShe = new ContentVO($contentShe);
        $this->readyHe = $readyHe;
        $this->readyShe = $readyShe;
        $this->slug = new SlugVO($slug);
        $this->title = new TitleVO($title);
        $this->categories = new CategoriesVO($categories);
        $this->views = new ViewsVO($views);
        $this->removed = $removed;
        $this->createDate = new Carbon($createDate);
        $this->publicationDate = '' !== $publicationDate ? new Carbon($publicationDate) : null;
    }
}
