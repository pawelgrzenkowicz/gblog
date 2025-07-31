<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\User\Provider;

use App\Domain\Shared\ValueObject\String\EmailVO;
use App\Domain\User\User;
use App\Infrastructure\Security\User\JWTUser;
use App\Infrastructure\Security\User\JWTUserRepositoryInterface;
use App\Infrastructure\Symfony\Error;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final readonly class JWTUserProvider implements UserProviderInterface
{
    public function __construct(private JWTUserRepositoryInterface $repository) {}

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        if (null === $user = $this->repository->byEmail(new EmailVO($identifier))) {
            throw new NotFoundHttpException(Error::USER_NOT_FOUND->value, code: 404);
        }

        return new JWTUser(
            (string) $user->email(),
            (string) $user->password(),
            $user->role()->value
        );
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): string
    {
        return User::class;
    }
}
