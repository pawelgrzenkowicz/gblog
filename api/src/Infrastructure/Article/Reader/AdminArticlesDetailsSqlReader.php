<?php

declare(strict_types=1);

namespace App\Infrastructure\Article\Reader;

use App\Application\Article\Reader\AdminArticleDetailsReader;
use App\Application\Article\View\AdminArticleDetailsView;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\UuidInterface;

final readonly class AdminArticlesDetailsSqlReader implements AdminArticleDetailsReader
{
    private const string SELECT = "
                    SELECT a.uuid, a.content_he, a.content_she, a.ready_he, a.ready_she, a.slug, a.title, a.categories,
                           a.views, a.removed, a.create_date, a.publication_date,
                           p.alt as picture_alt, p.extension as picture_extension, p.source as picture_source,
                           p.name as picture_name
                    FROM articles AS a
                    LEFT JOIN pictures as p ON a.main_picture_uuid = p.uuid
                    %s
                ";

    public function __construct(private Connection $connection) {}

    public function all(Pagination $pagination, Sort $sort): array
    {
        $params = sprintf(
            'ORDER BY %s %s LIMIT %d OFFSET %d',
            $sort->orderBy, $sort->order, $pagination->limit, ($pagination->page - 1) * $pagination->limit
        );

        $result = $this->connection
            ->fetchAllAssociative(
                sprintf(self::SELECT, $params)
            );

        return $this->transform($result);
    }

    public function byUuid(UuidInterface $uuid): ?AdminArticleDetailsView
    {
        $result = $this->connection
            ->fetchAssociative(
                sprintf(self::SELECT, 'WHERE a.uuid = :uuid'),
                ['uuid' => $uuid->toString()]
            );

        return $result ? $this->transform([$result])[0] : null;
    }

    public function bySlug(SlugVO $slug): ?AdminArticleDetailsView
    {
        $result = $this->connection
            ->fetchAssociative(
                sprintf(self::SELECT, 'WHERE a.slug = :slug'),
                ['slug' => $slug->__toString()]
            );


        return $result ? $this->transform([$result])[0] : null;
    }

    public function count(): int
    {
        $result = $this->connection
            ->fetchAssociative(
                "
                    SELECT COUNT(*) as count
                    FROM articles
                ");

        return $result['count'];
    }

    private function transform(array $records): array
    {
        return array_map(function ($record) {
            return new AdminArticleDetailsView(
                $record['uuid'],
                [
                    'he' => $record['content_he'],
                    'she' => $record['content_she'],
                ],
                (new Carbon($record['create_date']))->toAtomString(),
                [
                    'alt' => $record['picture_alt'],
                    'extension' => $record['picture_extension'],
                    'source' => $record['picture_source'],
                ],
                $record['slug'],
                $record['title'],
                $record['categories'],
                $record['publication_date'] ? (new Carbon($record['publication_date']))->toAtomString() : null,
                [
                    'he' => (bool) $record['ready_he'],
                    'she' => (bool) $record['ready_she'],
                ],
                (bool) $record['removed'],
                (int) $record['views'],
                $record['picture_name'],
                $record['publication_date'] ? (new Carbon($record['publication_date']))->format(PublicationDateVO::DATE_FORMAT) : null,
            );
        }, $records);
    }
}
