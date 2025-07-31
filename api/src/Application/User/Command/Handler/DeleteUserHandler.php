<?php

declare(strict_types=1);

namespace App\Application\User\Command\Handler;

use App\Application\User\Command\DeleteUser;
use App\Application\User\Exception\UserNotFoundException;
use App\Domain\User\UserRepositoryInterface;

readonly class DeleteUserHandler
{
    public function __construct(private UserRepositoryInterface $userRepository) {}

    public function __invoke(DeleteUser $command): void
    {
        if (!$user = $this->userRepository->byUuid($command->uuid)) {
            throw new UserNotFoundException();
        }

        $this->userRepository->delete($user);
    }
}
