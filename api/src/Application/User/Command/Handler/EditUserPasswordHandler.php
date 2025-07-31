<?php

declare(strict_types=1);

namespace App\Application\User\Command\Handler;

use App\Application\Exception\InvalidDataException;
use App\Application\User\Command\EditUserPassword;
use App\Application\User\Exception\UserNotFoundException;
use App\Application\User\Exception\WrongPasswordException;
use App\Domain\Shared\ValueObject\String\PasswordVO;
use App\Domain\User\TokenDecoderInterface;
use App\Domain\User\UserRepositoryInterface;

readonly class EditUserPasswordHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private TokenDecoderInterface $tokenDecoder
    ) {
    }

    public function __invoke(EditUserPassword $command): void
    {
        if (!$emailVO = $this->tokenDecoder->decodeEmail()) {
            throw new InvalidDataException();
        }

        if (!$user = $this->userRepository->byEmail($emailVO)) {
            throw new UserNotFoundException();
        }

        if (!$user->password()->matches($command->oldPassword->value)) {
            throw new WrongPasswordException();
        }

        $user->update(['password' => PasswordVO::fromPlainPassword($command->newPlainPassword)]);

        $this->userRepository->save($user);
    }
}
