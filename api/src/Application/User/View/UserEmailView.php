<?php

declare(strict_types=1);

namespace App\Application\User\View;

readonly class UserEmailView
{
    public function __construct(
        public string $uuid,
        public string $email
    ) {}
}
