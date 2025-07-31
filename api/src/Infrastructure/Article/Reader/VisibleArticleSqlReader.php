<?php

declare(strict_types=1);

namespace App\Infrastructure\Article\Reader;

use App\Application\Article\Reader\VisibleArticleReader;
use App\Application\Article\View\VisibleArticleView;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Domain\Article\Article;
use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use App\Domain\Shared\ValueObject\String\SlugVO;
use Carbon\Carbon;
use Doctrine\DBAL\Connection;

final readonly class VisibleArticleSqlReader implements VisibleArticleReader
{
    private const string SELECT = "
                    SELECT a.uuid, a.content_he, a.content_she, a.slug, a.title, a.views, a.categories, 
                           a.publication_date, a.removed, a.ready_he, a.ready_she,
                           p.alt as picture_alt, p.extension as picture_extension, p.source as picture_source,
                           p.name as picture_name
                    FROM articles AS a
                    LEFT JOIN pictures as p ON a.main_picture_uuid = p.uuid
                    %s
                ";

    public function __construct(private Connection $connection) {}

    public function all(Pagination $pagination, Sort $sort): array
    {
        $where = $this->provideVisibleCondition();

        $params = sprintf(
            '%s ORDER BY %s %s LIMIT %d OFFSET %d',
            $where, $sort->orderBy, $sort->order, $pagination->limit, ($pagination->page - 1) * $pagination->limit
        );

        $result = $this->connection
            ->fetchAllAssociative(
                sprintf(self::SELECT, $params)
            );

        return $this->transform($result);
    }

    public function bySlug(SlugVO $slug): ?VisibleArticleView
    {
        $where = $this->provideVisibleCondition();

        $params = sprintf(
            '%s AND a.slug = :slug',
            $where
        );

        $result = $this->connection
            ->fetchAssociative(
                sprintf(self::SELECT, $params),
                ['slug' => $slug]
            );

        return $result ? $this->transform([$result])[0] : null;
    }

    public function count(): int
    {
        $where = $this->provideVisibleCondition();

        $result = $this->connection
            ->fetchAssociative(
                sprintf(
                    "SELECT COUNT(*) as count
                    FROM articles as a
                    %s",
                    $where
                )
            );

        return $result['count'];


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

    private function provideVisibleCondition(): string
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        return "WHERE
            a.publication_date IS NOT NULL AND
            a.publication_date <= '$now' AND
            a.removed = false AND
            a.ready_he = true AND
            a.ready_she = true
            ";
    }

    private function transform(array $records): array
    {
        return array_map(function ($record) {
            return new VisibleArticleView(
                $record['uuid'],
                [
                    'he' => $record['content_he'],
                    'she' => $record['content_she'],
                ],
                [
                    'alt' => $record['picture_alt'],
                    'extension' => $record['picture_extension'],
                    'source' => $record['picture_source'],
                ],
                $record['slug'],
                $record['title'],
                (int) $record['views'],
                $record['categories'],
                (new Carbon($record['publication_date']))->toAtomString(),
            );
        }, $records);
    }
}
