<?php

declare(strict_types=1);

namespace App\Application\Article\Reader;

use App\Application\Article\View\VisibleArticleView;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Domain\Shared\ValueObject\String\SlugVO;

interface VisibleArticleReader
{
    /**
     * @param Pagination $pagination
     * @param Sort $sort
     * @return VisibleArticleView[]
     */
    public function all(Pagination $pagination, Sort $sort): array;

    public function bySlug(SlugVO $slug): ?VisibleArticleView;

    public function count(): int;
}
