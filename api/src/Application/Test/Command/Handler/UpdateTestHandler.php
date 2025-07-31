<?php

declare(strict_types=1);

namespace App\Application\Test\Command\Handler;

use App\Application\Test\Command\UpdateTest;
use App\Application\Test\Exception\TestNotFoundException;
use App\Domain\Test\TestRepositoryInterface;

readonly class UpdateTestHandler
{
    public function __construct(
        private TestRepositoryInterface $testRepository
    ) {}

    public function __invoke(UpdateTest $command): void
    {
        if (!$test = $this->testRepository->byUuid($command->uuid)) {
            throw new TestNotFoundException();
        }

        $test->update([
            'name' => $command->name,
            'number' => $command->number,
        ]);

        $this->testRepository->save($test);
    }
}
