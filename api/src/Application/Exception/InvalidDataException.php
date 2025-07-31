<?php

declare(strict_types=1);

namespace App\Application\Exception;

use App\Application\Shared\Error;
use RuntimeException;

class InvalidDataException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(Error::INVALID_DATA->value, 400);
    }
}
