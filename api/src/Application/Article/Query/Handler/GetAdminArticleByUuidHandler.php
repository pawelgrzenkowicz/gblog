<?php

declare(strict_types=1);

namespace App\Application\Article\Query\Handler;

use App\Application\Article\Query\GetAdminArticleByUuid;
use App\Application\Article\Reader\AdminArticleDetailsReader;
use App\Application\Article\View\AdminArticleDetailsView;

readonly class GetAdminArticleByUuidHandler
{
    public function __construct(private AdminArticleDetailsReader $reader)
    {
    }

    public function __invoke(GetAdminArticleByUuid $query): ?AdminArticleDetailsView
    {
        return $this->reader->byUuid($query->uuid);
    }
}
