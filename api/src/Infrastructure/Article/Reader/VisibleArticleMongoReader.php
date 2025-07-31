<?php

declare(strict_types=1);

namespace App\Infrastructure\Article\Reader;

use App\Application\Article\View\VisibleArticleView;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Domain\Article\Article;
use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use Carbon\Carbon;
use Doctrine\ODM\MongoDB\DocumentManager;

final readonly class VisibleArticleMongoReader
{
    private const array SELECT = ['uuid', 'contents', 'mainPicture', 'slug', 'title', 'views', 'categories',
        'publicationDate'];

    public function __construct(private DocumentManager $documentManager)
    {
    }

    public function all(Pagination $pagination, Sort $sort): array
    {
        $result = $this->documentManager->createQueryBuilder(Article::class)
            ->select(self::SELECT)
            ->field('publicationDate')->notEqual(null)
            ->field('publicationDate')->lte(new PublicationDateVO(Carbon::now()->format(PublicationDateVO::DATE_FORMAT)))
            ->field('removed')->equals(false)
            ->field('ready.he')->equals(true)
            ->field('ready.she')->equals(true)
            ->limit($limit = $pagination->limit)
            ->skip(($pagination->page - 1) * $limit)
            ->sort($sort->orderBy, $sort->order)
            ->getQuery()
            ->execute();

        return $this->transform($result->toArray());
    }

    public function bySlug(SlugVO $slug): ?VisibleArticleView
    {
        $result = $this->documentManager->createQueryBuilder(Article::class)
            ->select(self::SELECT)
            ->field('slug')->equals($slug)
            ->field('publicationDate')->notEqual(null)
            ->field('publicationDate')->lte(new PublicationDateVO(Carbon::now()->format(PublicationDateVO::DATE_FORMAT)))
            ->field('removed')->equals(false)
            ->field('ready.he')->equals(true)
            ->field('ready.she')->equals(true)
            ->getQuery()
            ->execute();

        return $this->transform($result->toArray())[0] ?? null;
    }

    public function count(): int
    {
        return $this->documentManager->createQueryBuilder(Article::class)
            ->count()
            ->field('publicationDate')->notEqual(null)
            ->field('publicationDate')->lte(new PublicationDateVO(Carbon::now()->format(PublicationDateVO::DATE_FORMAT)))
            ->field('removed')->equals(false)
            ->field('ready.he')->equals(true)
            ->field('ready.she')->equals(true)
            ->getQuery()
            ->execute();
    }

    private function transform(array $records): array
    {
        return array_map(function ($record) {
            return new VisibleArticleView(
                $record->uuid->__toString(),
                $record->contents()->toArray(),
                $record->mainPicture()->toArray(),
                $record->slug()->value,
                $record->title()->value,
                $record->views()->toInteger(),
                $record->categories()->toArray(),
                $record->publicationDate()?->value->toAtomString(),
            );
        }, $records);
    }
}
