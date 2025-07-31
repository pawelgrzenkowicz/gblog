<?php

declare(strict_types=1);

namespace App\Application\Article\Exception;

use App\Application\Shared\Error;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ArticleSlugAlreadyExistException extends HttpException
{
    private const int CODE = 422;

    public function __construct()
    {
        parent::__construct(self::CODE, Error::ARTICLE_SLUG_ALREADY_EXIST->value, code: self::CODE);
    }
}
