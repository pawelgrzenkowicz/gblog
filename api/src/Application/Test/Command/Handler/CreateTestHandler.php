<?php

declare(strict_types=1);

namespace App\Application\Test\Command\Handler;

use App\Application\Test\Command\CreateTest;
use App\Domain\Test\Test;
use App\Domain\Test\TestRepositoryInterface;

readonly class CreateTestHandler
{
    public function __construct(
        private TestRepositoryInterface $testRepository
    ) {}

    public function __invoke(CreateTest $command): string
    {
        $this->testRepository->save(
            new Test($uuid = $this->testRepository->uniqueUuid(), $command->name, $command->number)
        );

        return $uuid->toString();
    }
}
