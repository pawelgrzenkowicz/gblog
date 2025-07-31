<?php

declare(strict_types=1);

namespace App\Infrastructure\User\Reader;

use App\Application\User\Reader\UserEmailReader;
use App\Application\User\View\UserEmailView;
use App\Domain\User\User;
use Doctrine\ODM\MongoDB\DocumentManager;
use Ramsey\Uuid\UuidInterface;

final readonly class UserEmailMongoReader
{
    public function __construct(public DocumentManager $documentManager ) {}

    public function byUuid(UuidInterface $uuid): ?UserEmailView
    {
        $result = $this->documentManager->createQueryBuilder(User::class)
            ->select('uuid', 'email')
            ->field('uuid')->equals((string) $uuid)
            ->getQuery()
            ->execute();

        return empty($result->toArray()) ? null : $this->transform($result->toArray())[0];
    }

    private function transform(array $records): array
    {
        return array_map(function ($record) {
            return new UserEmailView(
                $record->uuid->__toString(),
                $record->email()->__toString()
            );

        }, $records);
    }
}
