<?php

declare(strict_types=1);

namespace App\Infrastructure\Article\Reader;

use App\Application\Article\View\AdminArticleDetailsView;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Domain\Article\ArticleMongo;
use App\Domain\Shared\ValueObject\String\SlugVO;
use Doctrine\ODM\MongoDB\DocumentManager;
use Ramsey\Uuid\UuidInterface;

class AdminArticlesDetailsMongoReader
{
    private const array SELECT = ['uuid', 'contents', 'createDate', 'mainPicture', 'publicationDate', 'ready', 'removed',
        'slug', 'title', 'categories', 'views'];

    public function __construct(private DocumentManager $documentManager)
    {
    }

    public function all(Pagination $pagination, Sort $sort): array
    {
        $result = $this->documentManager->createQueryBuilder(ArticleMongo::class)
            ->select(self::SELECT)
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

    public function byUuid(UuidInterface $uuid): ?AdminArticleDetailsView
    {
        $result = $this->documentManager->createQueryBuilder(ArticleMongo::class)
            ->select(self::SELECT)
            ->field('uuid')->equals($uuid)
            ->getQuery()
            ->execute();

        return $this->transform($result->toArray())[0] ?? null;
    }

    public function bySlug(SlugVO $slug): ?AdminArticleDetailsView
    {
        $result = $this->documentManager->createQueryBuilder(ArticleMongo::class)
            ->select(self::SELECT)
            ->field('slug')->equals($slug)
            ->getQuery()
            ->execute();

        return $this->transform($result->toArray())[0] ?? null;
    }

    public function count(): int
    {
        return $this->documentManager->createQueryBuilder(ArticleMongo::class)
            ->count()
            ->getQuery()
            ->execute();
    }

    private function transform(array $records): array
    {
        return array_map(function ($record) {
            return new AdminArticleDetailsView(
                $record->uuid->__toString(),
                $record->contents()->toArray(),
                $record->createDate()->value->toAtomString(),
                $record->mainPicture()->toArray(),
                $record->slug()->value,
                $record->title()->value,
                implode(',', $record->categories()->values),
                $record->publicationDate()?->value->toAtomString() ?? null,
                $record->ready()->toArray(),
                $record->removed(),
                $record->views()->value,
                $record->mainPicture()->pictureName(),
//                $record->categories()->toString(),
                $record->publicationDate()?->formattedDate() ?? null,
            );
        }, $records);
    }
}
