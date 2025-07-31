<?php

declare(strict_types=1);

namespace App\Application\Article\Reader;

use App\Application\Article\View\AdminArticleDetailsView;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Domain\Shared\ValueObject\String\SlugVO;
use Ramsey\Uuid\UuidInterface;

interface AdminArticleDetailsReader
{
    /**
     * @param Pagination $pagination
     * @param Sort $sort
     * @return AdminArticleDetailsView[]
     */
    public function all(Pagination $pagination, Sort $sort): array;

    public function byUuid(UuidInterface $uuid): ?AdminArticleDetailsView;

    public function bySlug(SlugVO $slug): ?AdminArticleDetailsView;

    public function count(): int;
}
