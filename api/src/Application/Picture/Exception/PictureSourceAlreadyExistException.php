<?php

declare(strict_types=1);

namespace App\Application\Picture\Exception;

use App\Application\Shared\Error;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PictureSourceAlreadyExistException extends HttpException
{
    private const int CODE = 422;

    public function __construct()
    {
        parent::__construct(self::CODE, Error::PICTURE_SOURCE_ALREADY_EXIST->value, code: self::CODE);
    }
}
