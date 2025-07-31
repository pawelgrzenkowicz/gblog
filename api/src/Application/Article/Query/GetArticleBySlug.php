<?php

declare(strict_types=1);

namespace App\Application\Article\Query;

use App\Domain\Shared\ValueObject\String\SlugVO;

readonly class GetArticleBySlug
{
    public SlugVO $slug;

    public function __construct(string $slug)
    {
        $this->slug = new SlugVO($slug);
    }
}
