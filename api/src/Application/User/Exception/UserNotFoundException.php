<?php

declare(strict_types=1);

namespace App\Application\User\Exception;

use App\Application\Shared\Error;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserNotFoundException extends HttpException
{
    private const int CODE = 404;

    public function __construct()
    {
        parent::__construct(self::CODE, Error::USER_NOT_FOUND->value, code: self::CODE);
    }
}
