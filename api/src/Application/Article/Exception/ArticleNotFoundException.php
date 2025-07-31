<?php

declare(strict_types=1);

namespace App\Application\Article\Exception;

use App\Application\Shared\Error;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ArticleNotFoundException extends HttpException
{
    private const int CODE = 404;

    public function __construct()
    {
        parent::__construct(self::CODE, Error::ARTICLE_DOES_NOT_EXIST->value, code: self::CODE);
    }
}
