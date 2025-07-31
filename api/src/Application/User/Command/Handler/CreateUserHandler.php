<?php

declare(strict_types=1);

namespace App\Application\User\Command\Handler;

use App\Application\User\Command\CreateUser;
use App\Application\User\Exception\UserEmailAlreadyExistException;
use App\Application\User\Exception\UserNicknameAlreadyExistException;
use App\Domain\Shared\ValueObject\String\PasswordVO;
use App\Domain\User\User;
use App\Domain\User\UserRepositoryInterface;

readonly class CreateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(CreateUser $command): string
    {
        if ($this->userRepository->byEmail($email = $command->email)) {
            throw new UserEmailAlreadyExistException();
        }

        if ($this->userRepository->byNickname($nickname = $command->nickname)) {
            throw new UserNicknameAlreadyExistException();
        }

        $user = new User(
            $uuid = $this->userRepository->uniqueUuid(),
            $email,
            $nickname,
            PasswordVO::fromPlainPassword($command->plainPassword),
            $command->role
        );

        $this->userRepository->save($user);

        return $uuid->toString();
    }
}
