<?php

declare(strict_types=1);

namespace App\Application\User\Reader;

use App\Application\User\View\UserEmailView;
use Ramsey\Uuid\UuidInterface;

interface UserEmailReader
{
    public function byUuid(UuidInterface $uuid): ?UserEmailView;
}
