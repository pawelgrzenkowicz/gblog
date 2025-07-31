<?php

declare(strict_types=1);

namespace App\Application\Article\Command;

use App\Domain\Picture\Picture;
use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Domain\Shared\ValueObject\String\CategoriesVO;
use App\Domain\Shared\ValueObject\String\ContentVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Domain\Shared\ValueObject\String\TitleVO;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class CreateArticle
{
    public CategoriesVO $categories;

    public ContentVO $contentHe;
    public ContentVO $contentShe;

    public Picture $picture;

    public bool $readyHe;
    public bool $readyShe;

    public SlugVO $slug;

    public TitleVO $title;

    public ViewsVO $views;

    public bool $removed;

    public CarbonInterface $createDate;

    public ?CarbonInterface $publicationDate;

    public function __construct(
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
        string $publicationDate
    ) {
        $this->picture = $picture;
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
