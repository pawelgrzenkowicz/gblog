<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Query;

use App\Application\Test\Query\GetSingleTest;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetSingleTestTest extends TestCase
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

    private function createInstanceUnderTest(string $uuid): GetSingleTest
    {
        return new GetSingleTest($uuid);
    }
}
