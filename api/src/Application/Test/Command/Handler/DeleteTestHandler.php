<?php

declare(strict_types=1);

namespace App\Application\Test\Command\Handler;

use App\Application\Test\Command\DeleteTest;
use App\Application\Test\Exception\TestNotFoundException;
use App\Domain\Test\TestRepositoryInterface;

readonly class DeleteTestHandler
{
    public function __construct(
        private TestRepositoryInterface $testRepository
    ) {}

    public function __invoke(DeleteTest $command): void
    {
        if (!$test = $this->testRepository->byUuid($command->uuid)) {
            throw new TestNotFoundException();
        }

        $this->testRepository->delete($test);
    }
}
