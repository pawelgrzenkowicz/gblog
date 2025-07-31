<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundException extends NotFoundHttpException
{
    private const int CODE = 404;

    public function __construct(string $message = '')
    {
        parent::__construct($message, code: self::CODE);
    }
}
