<?php

declare(strict_types=1);

namespace App\Application\Article\Query\Handler;

use App\Application\Article\Query\GetArticleBySlug;
use App\Application\Article\Reader\VisibleArticleReader;
use App\Application\Article\View\VisibleArticleView;
use App\Domain\Article\ArticleRepositoryInterface;

readonly class GetArticleBySlugHandler
{
    private const int INCREASE_VIEWS = 1;

    public function __construct(private VisibleArticleReader $reader, private ArticleRepositoryInterface $articleRepository)
    {
    }

    public function __invoke(GetArticleBySlug $query): ?VisibleArticleView
    {
        if ($article = $this->articleRepository->bySlug($query->slug)) {
            $article->increaseViews(self::INCREASE_VIEWS);
            $this->articleRepository->save($article);
        }

        return $this->reader->bySlug($query->slug);
    }
}
