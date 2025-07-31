<?php

declare(strict_types=1);

namespace App\Application\Article\Query\Handler;

use App\Application\Article\Query\GetAdminArticles;
use App\Application\Article\Reader\AdminArticleDetailsReader;

readonly class GetAdminArticlesHandler
{
    public function __construct(private AdminArticleDetailsReader $reader)
    {
    }

    public function __invoke(GetAdminArticles $query): array
    {
        $result = $this->reader->all($query->pagination, $query->sort);
        $totalItems = $this->reader->count();

        return [
            'items' => $result,
            'total' => $totalItems,
        ];
    }
}
