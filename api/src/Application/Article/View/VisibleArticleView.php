<?php

declare(strict_types=1);

namespace App\Application\Article\View;

final readonly class VisibleArticleView
{
    public function __construct(
        public string $uuid,
        public array $contents,
        public array $mainPicture,
        public string $slug,
        public string $title,
        public int $views,
        public string $categories,
        public ?string $publicationDate
    ) {}
}
