<?php

declare(strict_types=1);

namespace App\Application\User\Exception;

use App\Application\Shared\Error;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WrongPasswordException extends HttpException
{
    private const int CODE = 400;

    public function __construct()
    {
        parent::__construct(self::CODE, Error::WRONG_PASSWORD->value, code: self::CODE);
    }
}
