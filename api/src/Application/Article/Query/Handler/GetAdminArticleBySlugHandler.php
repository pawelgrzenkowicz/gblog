<?php

declare(strict_types=1);

namespace App\Application\Article\Query\Handler;

use App\Application\Article\Query\GetAdminArticleBySlug;
use App\Application\Article\Reader\AdminArticleDetailsReader;
use App\Application\Article\View\AdminArticleDetailsView;

readonly class GetAdminArticleBySlugHandler
{
    public function __construct(private AdminArticleDetailsReader $reader) {}

    public function __invoke(GetAdminArticleBySlug $query): ?AdminArticleDetailsView
    {
        return $this->reader->bySlug($query->slug);
    }
}
