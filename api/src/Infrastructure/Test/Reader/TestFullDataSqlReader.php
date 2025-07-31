<?php

declare(strict_types=1);

namespace App\Infrastructure\Test\Reader;

use App\Application\Test\Reader\TestFullDataReader;
use App\Application\Test\View\TestFullDataView;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\UuidInterface;

readonly class TestFullDataSqlReader implements TestFullDataReader
{
    public function __construct(private Connection $connection) {}

    public function all(): array
    {
        $result = $this->connection
            ->fetchAllAssociative(
                "SELECT * FROM tests"
            );

        return $this->transform($result);
    }

    public function byUuid(UuidInterface $uuid): ?TestFullDataView
    {
        $result = $this->connection
            ->fetchAssociative(
                "SELECT * FROM tests WHERE uuid = :uuid",
                ['uuid' => $uuid->toString()]
            );

        return $result ? $this->transform([$result])[0] : null;
    }

    private function transform(array $records): array
    {
        return array_map(function ($record) {
            return new TestFullDataView(
                $record['uuid'],
                $record['name'],
                (int) $record['number']
            );

        }, $records);
    }
}
