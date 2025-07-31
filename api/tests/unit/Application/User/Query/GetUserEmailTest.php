<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\User\Query;

use App\Application\User\Query\GetUserEmail;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetUserEmailTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $uuid = Uuid::uuid4();

        // When
        $actual = $this->createInstanceUnderTest($uuid->toString());

        // Then
        $this->assertEquals($uuid, $actual->uuid);
    }

    private function createInstanceUnderTest(string $uuid): GetUserEmail
    {
        return new GetUserEmail($uuid);
    }
}
