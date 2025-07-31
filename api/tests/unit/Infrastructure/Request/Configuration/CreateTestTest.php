<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Request\Configuration;

use App\Infrastructure\Request\Configuration\CreateTest;
use PHPUnit\Framework\TestCase;

class CreateTestTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $config = $this->createInstanceUnderTest();

        // Then
        $this->assertSame(2, $config->requestLimit);
        $this->assertSame('test.create', $config->route);
        $this->assertSame('10 hour', $config->timeFrame);
    }

    private function createInstanceUnderTest(): CreateTest
    {
        return new CreateTest();
    }
}
