<?php

declare(strict_types=1);

namespace App\Application\Article\Query\Handler;


use App\Application\Article\Query\GetVisibleArticle;
use App\Application\Article\Reader\VisibleArticleReader;

readonly class GetVisibleArticlesHandler
{
    public function __construct(private VisibleArticleReader $reader)
    {
    }

    public function __invoke(GetVisibleArticle $query): array
    {
        $result = $this->reader->all($query->pagination, $query->sort);
        $total = $this->reader->count();

        return [
            'items' => $result,
            'total' => $total,
        ];
    }
}
