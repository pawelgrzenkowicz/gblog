<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Request\Configuration;

use App\Infrastructure\Request\Configuration\CreateUser;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $config = $this->createInstanceUnderTest();

        // Then
        $this->assertSame(5, $config->requestLimit);
        $this->assertSame('user.create', $config->route);
        $this->assertSame('1 day', $config->timeFrame);
    }

    private function createInstanceUnderTest(): CreateUser
    {
        return new CreateUser();
    }
}
