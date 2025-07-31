<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\String;

use App\Domain\Shared\Enum\Role;
use App\Infrastructure\Database\Doctrine\Type\String\RoleType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;

class RoleTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(RoleType::getTypeName(), RoleType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Then
        $this->assertSame(
            Role::FREE_USER->value,
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createEnum(Role::FREE_USER->value))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Then
        $this->assertEquals(
            Role::FREE_USER,
            $this->createInstanceUnderTest()->convertToPHPValue(Role::FREE_USER->value)
        );
    }

    public function testShouldReturnValidTypeName(): void
    {
        $this->assertSame('role_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): RoleType
    {
        return RoleType::getType(RoleType::getTypeName());
    }

    private function createEnum(string $role): Role
    {
        return Role::from($role);
    }
}
