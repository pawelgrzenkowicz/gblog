<?php

declare(strict_types=1);

namespace App\Application\Article\Query\Handler;

use App\Application\Article\Query\GetAdminArticlesMongo;
use App\Infrastructure\Article\Reader\AdminArticlesDetailsMongoReader;

readonly class GetAdminArticlesMongoHandler
{
    public function __construct(private AdminArticlesDetailsMongoReader $reader) {}

    public function __invoke(GetAdminArticlesMongo $query): array
    {
        $result = $this->reader->all($query->pagination, $query->sort);
        $totalItems = $this->reader->count();

        return [
            'items' => $result,
            'total' => $totalItems,
        ];
    }
}
