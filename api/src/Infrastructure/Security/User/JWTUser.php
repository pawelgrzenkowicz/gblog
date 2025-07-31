<?php

declare(strict_types=1);

namespace App\Infrastructure\Security\User;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class JWTUser implements PasswordAuthenticatedUserInterface, UserInterface
{
    public function __construct(
        private readonly string $email,
        private readonly string $password,
        private readonly string $role
    ) {}

    public function eraseCredentials()
    {
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
