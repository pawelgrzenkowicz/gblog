<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Http\Controller;

use App\Infrastructure\Http\Controller\ErrorResponse;
use App\UI\Http\Rest\Error\ErrorType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ErrorResponseTest extends TestCase
{
    public static function provideType(): array
    {
        return [
            [
                'type' => ErrorType::INTERNAL_ERROR->value,
            ],
        ];
    }

    #[DataProvider('provideType')]
    public function testShouldReturnCorrectDate(string $type): void
    {
        // When
        $response = $this->createInstanceUnderTest($type);

        // Then
        $this->assertEquals($type, $response->type);
        $this->assertEquals(['type' => $type], $response->jsonSerialize());
    }

    private function createInstanceUnderTest(string $type): ErrorResponse
    {
        return new ErrorResponse($type);
    }
}
