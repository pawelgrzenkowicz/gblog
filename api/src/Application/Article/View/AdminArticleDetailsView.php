<?php

declare(strict_types=1);

namespace App\Application\Article\View;

final readonly class AdminArticleDetailsView
{
    public function __construct(
        public string $uuid,
        public array $contents,
        public string $createDate,
        public array $mainPicture,
        public string $slug,
        public string $title,
        public string $categories,
        public ?string $publicationDate,
        public array $ready,
        public bool $removed,
        public int $views,
        public string $mainPictureName,
        public ?string $publicationDateFormatted,
    ) {}
}
