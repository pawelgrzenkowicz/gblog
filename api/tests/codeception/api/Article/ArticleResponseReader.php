<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\Article;

trait ArticleResponseReader
{
    protected function getArticleList(string $file): array
    {
        return json_decode(file_get_contents(__DIR__ . sprintf('/../../_data/responses/%s', $file)), true);
    }
}
