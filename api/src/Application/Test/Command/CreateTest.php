<?php

declare(strict_types=1);

namespace App\Application\Test\Command;

use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use App\Domain\Shared\ValueObject\String\TestNameVO;

readonly class CreateTest
{
    public TestNameVO $name;
    public TestNumberVO $number;

    public function __construct(string $name, int $number)
    {
        $this->name = new TestNameVO($name);
        $this->number = new TestNumberVO($number);
    }
}
