<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\User\Command;

use App\Application\User\Command\DeleteUser;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteUserTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $uuid = Uuid::uuid4();

        // When
        $deleteUser = $this->createInstanceUnderTest($uuid->toString());

        // Then
        $this->assertEquals($uuid, $deleteUser->uuid);
    }

    private function createInstanceUnderTest(string $uuid): DeleteUser
    {
        return new DeleteUser($uuid);
    }
}
