<?php

declare(strict_types=1);

namespace App\Application\User\Query\Handler;

use App\Application\User\Query\GetUserEmail;
use App\Application\User\Reader\UserEmailReader;
use App\Application\User\View\UserEmailView;

readonly class GetUserEmailHandler
{
    public function __construct(
        private UserEmailReader $userEmailReader
    ) {}

    public function __invoke(GetUserEmail $query): ?UserEmailView
    {
        return $this->userEmailReader->byUuid($query->uuid);
    }
}
