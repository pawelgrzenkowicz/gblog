<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Shared;

use App\Application\Shared\Sort;
use Codeception\PHPUnit\TestCase;

class SortTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $actual = $this->createInstanceUnderTest($orderBy = uniqid(), $order = uniqid());

        // Then
        $this->assertSame($orderBy, $actual->orderBy);
        $this->assertSame($order, $actual->order);
    }

    private function createInstanceUnderTest(string $orderBy, string $order): Sort
    {
        return new Sort($orderBy, $order);
    }
}
