<?php

declare(strict_types=1);

namespace App\Application\Test\Command;

use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use App\Domain\Shared\ValueObject\String\TestNameVO;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

readonly class UpdateTest
{
    public UuidInterface $uuid;

    public TestNameVO $name;

    public TestNumberVO $number;

    public function __construct(string $uuid, string $name, int $number)
    {
        $this->uuid = Uuid::fromString($uuid);
        $this->name = new TestNameVO($name);
        $this->number = new TestNumberVO($number);
    }
}
