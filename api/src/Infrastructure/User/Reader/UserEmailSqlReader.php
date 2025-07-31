<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Reader;

use App\Application\User\Reader\UserEmailReader;
use App\Application\User\View\UserEmailView;
use Doctrine\DBAL\Connection;
use Ramsey\Uuid\UuidInterface;

final readonly class UserEmailSqlReader implements UserEmailReader
{
    public function __construct(private Connection $connection) {}

    public function byUuid(UuidInterface $uuid): ?UserEmailView
    {
        $result = $this->connection
            ->fetchAssociative(
                "SELECT uuid, email FROM users WHERE uuid = :uuid",
                ['uuid' => $uuid->toString()]
            );

        return $result ? $this->transform([$result])[0] : null;
    }

    private function transform(array $records): array
    {
        return array_map(function ($record) {
            return new UserEmailView(
                $record['uuid'],
                $record['email'],
            );

        }, $records);
    }
}
