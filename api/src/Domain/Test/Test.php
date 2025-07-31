<?php

declare(strict_types=1);

namespace App\Domain\Test;

use App\Domain\External;
use App\Domain\ExternalTrait;
use App\Domain\Internal;
use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use App\Domain\Shared\ValueObject\String\TestNameVO;
use Ramsey\Uuid\UuidInterface;

class Test
{
    use ExternalTrait;

    #[Internal]
    public readonly UuidInterface $uuid;

    #[External]
    private TestNameVO $name;

    #[External]
    private TestNumberVO $number;

    public function __construct(UuidInterface $uuid, TestNameVO $name, TestNumberVO $number)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->number = $number;
    }

    public function name(): TestNameVO
    {
        return $this->name;
    }

    public function number(): TestNumberVO
    {
        return $this->number;
    }
}
