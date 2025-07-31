<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Query;

use App\Application\Test\Query\GetTest;
use PHPUnit\Framework\TestCase;

class GetTestTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Then
        $this->assertNotEmpty(new GetTest());
    }
}
