<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Reader;

use App\Application\Test\Reader\TestFullDataReader;
use App\Application\Test\View\TestFullDataView;
use App\Domain\Test\Test;
use Doctrine\ODM\MongoDB\DocumentManager;
use Ramsey\Uuid\UuidInterface;

final readonly class TestFullDataMongoReader
{
    public function __construct(private DocumentManager $documentManager) {}

    public function all(): array
    {
        $result = $this->documentManager->createQueryBuilder(Test::class)
            ->select('uuid', 'name', 'number')
            ->getQuery()
            ->execute();

        return $this->transform($result->toArray());
    }

    public function byUuid(UuidInterface $uuid): ?TestFullDataView
    {
        $result = $this->documentManager->createQueryBuilder(Test::class)
            ->field('uuid')->equals($uuid)
            ->getQuery()
            ->execute();

        return $this->transform($result->toArray())[0] ?? null;
    }

    private function transform(array $records): array
    {
        return array_map(function ($record) {
            return new TestFullDataView(
                $record->uuid->__toString(),
                $record->name()->__toString(),
                $record->number()->toInteger()
            );

        }, $records);
    }
}
