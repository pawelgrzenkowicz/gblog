<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Command;

use App\Application\Test\Command\CreateTest;
use PHPUnit\Framework\TestCase;

class CreateTestTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $name = uniqid();
        $number = rand(1, 100);

        // When
        $actual = new CreateTest($name, $number);

        // Then
        $this->assertSame($number, $actual->number->toInteger());
        $this->assertSame($name, $actual->name->__toString());
    }
}
