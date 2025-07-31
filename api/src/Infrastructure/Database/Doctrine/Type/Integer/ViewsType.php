<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Doctrine\Type\Integer;

use App\Domain\Shared\ValueObject\Number\ViewsVO;
use Doctrine\ODM\MongoDB\Types\ClosureToPHP;
use Doctrine\ODM\MongoDB\Types\Type;

class ViewsType extends Type
{
    use ClosureToPHP;

    public function convertToDatabaseValue($value): int
    {
        return $value->value;
    }

    public function convertToPHPValue($value): ViewsVO
    {
        return new ViewsVO($value);
    }

    public static function getTypeName(): string
    {
        return "views_type";
    }
}
