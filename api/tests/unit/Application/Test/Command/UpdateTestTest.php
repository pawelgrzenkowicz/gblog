<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Command;

use App\Application\Test\Command\UpdateTest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UpdateTestTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $name = uniqid();
        $number = rand(1, 100);

        // When
        $actual = new UpdateTest($uuid->toString(), $name, $number);

        // Then
        $this->assertEquals($uuid, $actual->uuid);
        $this->assertSame($name, $actual->name->__toString());
        $this->assertSame($number, $actual->number->toInteger());
    }
}
