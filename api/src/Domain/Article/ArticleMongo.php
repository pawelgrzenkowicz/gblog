<?php

declare(strict_types=1);

namespace App\Domain\Article;

use App\Domain\External;
use App\Domain\ExternalTrait;
use App\Domain\Internal;
use App\Domain\Shared\ValueObject\Date\CreateDateVO;
use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use App\Domain\Shared\ValueObject\Iterable\CategoriesVO;
use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Domain\Shared\ValueObject\Object\ArticleReadyVO;
use App\Domain\Shared\ValueObject\Object\ContentsVO;
use App\Domain\Shared\ValueObject\Object\PictureVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Domain\Shared\ValueObject\String\TitleVO;
use Ramsey\Uuid\UuidInterface;

class ArticleMongo
{
    use ExternalTrait;

    #[Internal]
    public readonly UuidInterface $uuid;

    #[External]
    private CategoriesVO $categories;

    #[External]
    private ContentsVO $contents;

    #[External]
    private PictureVO $mainPicture;

    #[External]
    private ArticleReadyVO $ready;

    #[External]
    private SlugVO $slug;

    #[External]
    private TitleVO $title;

    #[External]
    private ViewsVO $views;

    #[External]
    private bool $removed;

// komentarze - tablica, autor

    #[External]
    private CreateDateVO $createDate;

    #[External]
    private ?PublicationDateVO $publicationDate;

    public function __construct(
        UuidInterface $uuid,
        ContentsVO $contents,
        PictureVO $mainPicture,
        ArticleReadyVO $ready,
        SlugVO $slug,
        TitleVO $title,
        CategoriesVO $categories,
        ViewsVO $views,
        bool $removed,
        CreateDateVO $createDate,
        ?PublicationDateVO $publicationDate
    ) {
        $this->uuid = $uuid;
        $this->contents = $contents;
        $this->mainPicture = $mainPicture;
        $this->ready = $ready;
        $this->slug = $slug;
        $this->title = $title;
        $this->categories = $categories;
        $this->views = $views;
        $this->removed = $removed;
        $this->createDate = $createDate;
        $this->publicationDate = $publicationDate;
    }

    public function categories(): CategoriesVO
    {
        return $this->categories;
    }

    public function createDate(): CreateDateVO
    {
        return $this->createDate;
    }

    public function contents():  ContentsVO
    {
        return $this->contents;
    }

    public function mainPicture(): PictureVO
    {
        return $this->mainPicture;
    }

    public function publicationDate(): ?PublicationDateVO
    {
        return $this->publicationDate;
    }

    public function ready(): ArticleReadyVO
    {
        return $this->ready;
    }

    public function removed(): bool
    {
        return $this->removed;
    }

    public function slug(): SlugVO
    {
        return $this->slug;
    }

    public function title(): TitleVO
    {
        return $this->title;
    }

    public function views(): ViewsVO
    {
        return $this->views;
    }

    public function increaseViews(int $increase): void
    {
        $this->views = new ViewsVO($this->views->toInteger() + $increase);
    }
}
