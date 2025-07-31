<?php

declare(strict_types=1);

namespace App\Domain\Article;

use App\Domain\External;
use App\Domain\ExternalTrait;
use App\Domain\Internal;
use App\Domain\Picture\Picture;
use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Domain\Shared\ValueObject\Object\ContentsVO;
use App\Domain\Shared\ValueObject\String\CategoriesVO;
use App\Domain\Shared\ValueObject\String\ContentVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Domain\Shared\ValueObject\String\TitleVO;
use Carbon\CarbonInterface;
use Ramsey\Uuid\UuidInterface;

class Article
{
    use ExternalTrait;

    #[Internal]
    public readonly UuidInterface $uuid;

    #[External]
    private CategoriesVO $categories;

    #[External]
    private ContentVO $contentHe;

    #[External]
    private ContentVO $contentShe;

    #[External]
    private Picture $mainPicture;

    #[External]
    private bool $readyHe;

    #[External]
    private bool $readyShe;

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
    private CarbonInterface $createDate;

    #[External]
    private ?CarbonInterface $publicationDate;

    public function __construct(
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
    ) {
        $this->uuid = $uuid;
        $this->mainPicture = $mainPicture;
        $this->contentHe = $contentHe;
        $this->contentShe = $contentShe;
        $this->readyHe = $readyHe;
        $this->readyShe = $readyShe;
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

    public function createDate(): CarbonInterface
    {
        return $this->createDate;
    }

    public function createDateToAtom(): string
    {
        return $this->createDate->toAtomString();
    }

    public function contentHe():  ContentVO
    {
        return $this->contentHe;
    }

    public function contentShe():  ContentVO
    {
        return $this->contentShe;
    }

    public function mainPicture(): Picture
    {
        return $this->mainPicture;
    }

    public function publicationDate(): ?CarbonInterface
    {
        return $this->publicationDate;
    }

    public function publicationDateFormatted(): string
    {
        return $this->publicationDate?->format(PublicationDateVO::DATE_FORMAT) ?? '';
    }

    public function readyHe(): bool
    {

        return $this->readyHe;
    }

    public function readyShe(): bool
    {

        return $this->readyShe;
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
