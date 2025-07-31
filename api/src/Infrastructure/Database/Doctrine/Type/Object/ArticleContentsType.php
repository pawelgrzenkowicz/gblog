<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\Object;

use App\Domain\Shared\ValueObject\Object\ContentsVO;
use App\Domain\Shared\ValueObject\String\ContentVO;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ArticleContentsType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): ?array
    {
        if ($value !== null && !($value instanceof ContentsVO)) {
            throw new UnprocessableEntityHttpException(Error::INVALID_DATA->value);
        }

        return ["he" => $value->he->value, "she" => $value->she->value];
    }

    public function convertToPHPValue($value): ?ContentsVO
    {
        if (null === $value) {
            return null;
        }

        if (!is_array($value)) {
            throw new UnprocessableEntityHttpException(Error::INVALID_DATA->value);
        }

        return new ContentsVO(new ContentVO($value["he"]), new ContentVO($value["she"]));
    }

    public static function getTypeName(): string
    {
        return "article_contents_type";
    }
}
