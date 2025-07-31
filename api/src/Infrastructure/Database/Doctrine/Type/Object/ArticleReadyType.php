<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\Object;

use App\Domain\Shared\ValueObject\Object\ArticleReadyVO;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

final class ArticleReadyType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?array
    {
        if ($value !== null && !($value instanceof ArticleReadyVO)) {
            throw new UnprocessableEntityHttpException(Error::INVALID_DATA->value);
        }

        return ["he" => $value->he, "she" => $value->she];
    }

    public function convertToPHPValue($value): ?ArticleReadyVO
    {
        if (null === $value) {
            return null;
        }

        if (!is_array($value)) {
            throw new UnprocessableEntityHttpException(Error::INVALID_DATA->value);
        }

        return new ArticleReadyVO($value["he"], $value["she"]);
    }

    public static function getTypeName(): string
    {
        return "article_ready_type";
    }
}
