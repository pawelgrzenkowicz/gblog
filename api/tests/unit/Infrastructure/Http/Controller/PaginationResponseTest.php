<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Http\Controller;

use App\Infrastructure\Http\Controller\PaginationResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PaginationResponseTest extends TestCase
{
    public static function providePages(): array
    {
        return [
            [
                'page' => 1,
            ],
            [
                'page' => 7,
            ],

            [
                'page' => 12,
            ],
        ];
    }

    #[DataProvider('providePages')]
    public function testShouldReturnCorrectDate(int $page): void
    {
        // Given
        $items = [];

        for ($i = 0; $i < $total = rand(1, 10); $i++) {
            $items[] = $i;
        }

        // When
        $response = $this->createInstanceUnderTest($items, $page, $total);

        // Then
        $this->assertEquals($page, $response->page);
        $this->assertEquals($total, $response->total);
        $this->assertEquals($items, $response->items);
        $this->assertEquals(['items' => $items, 'page' => $page, 'total' => $total], $response->jsonSerialize());
    }

    public function testShouldDefaultDataWhenNoArguments(): void
    {
        // Then
        $this->assertEquals(['items' => [], 'page' => 1, 'total' => 0], (new PaginationResponse())->jsonSerialize());
    }

    private function createInstanceUnderTest(array $items, int $page, int $total): PaginationResponse
    {
        return new PaginationResponse($items, $page, $total);
    }
}
