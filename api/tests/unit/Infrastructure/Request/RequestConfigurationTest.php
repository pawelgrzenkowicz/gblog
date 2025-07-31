<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Request;

use App\Infrastructure\Request\Config;
use App\Infrastructure\Request\RequestConfiguration;
use Codeception\PHPUnit\TestCase;

class RequestConfigurationTest extends TestCase
{
    public function testShouldCheckClassInstance(): void
    {
        // When
        $requestConfiguration = $this->createInstanceUnderTest();

        // Then
        foreach ($requestConfiguration::get() as $config) {
            $this->assertInstanceOf(Config::class, $config);
        }

    }

    private function createInstanceUnderTest(): RequestConfiguration
    {
        return new RequestConfiguration();
    }
}
