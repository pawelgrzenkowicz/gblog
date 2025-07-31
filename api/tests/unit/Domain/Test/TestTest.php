<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Test;

use App\Domain\ExternalTrait;
use App\Domain\Shared\ValueObject\Number\TestNumberVO;
use App\Domain\Shared\ValueObject\String\TestNameVO;
use App\Domain\Test\Test;
use Exception;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class TestTest extends TestCase
{
    use ExternalTrait;

    public function testShouldCreateValidObject(): void
    {
        // Given
        $name = uniqid();
        $number = random_int(1, 100);
        $testClass = $this->createInstanceUnderTest(Uuid::uuid4(), $name, $number);

        // Then
        $this->assertInstanceOf(UuidInterface::class, $testClass->uuid);
        $this->assertSame($name, $testClass->name()->__toString());
        $this->assertSame($number, $testClass->number()->toInteger());
    }

    public function testShouldUpdateExternalProperty()
    {
        // Given
        $name = uniqid();
        $number = random_int(11, 100);
        $testClass = $this->createInstanceUnderTest(Uuid::uuid4(), $name, $number);

        // When
        $testClass->update([
            'name' => new TestNameVO($newName = uniqid()),
            'number' => new TestNumberVO($newNumber = rand(1, 10)),
        ]);

        // Then
        $this->assertSame($newName, $testClass->name()->__toString());
        $this->assertSame($newNumber, $testClass->number()->toInteger());
    }

    public function testThrowExceptionWhenPropertyNotExist(): void
    {
        // Given
        $notExistProperty = uniqid();
        $testClass = $this->createInstanceUnderTest(Uuid::uuid4(), uniqid(), rand(1, 100));

        // Exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('PROPERTY_DOES_NOT_EXIST');

        // When
        $testClass->update([$notExistProperty => uniqid()]);
    }

    public function testShouldThrowExceptionWhenPropertyIsNotExternal(): void
    {
        // Given
        $testClass = $this->createInstanceUnderTest(Uuid::uuid4(), uniqid(), rand(1, 100));

        // Exception
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('CANNOT_MODIFY_PROPERTY');

        // Then
        $testClass->update(['uuid' => Uuid::uuid4()]);
    }

    private function createInstanceUnderTest(UuidInterface $uuid, string $name, int $number): Test
    {
        return new Test($uuid, new TestNameVO($name), new TestNumberVO($number));
    }
}
