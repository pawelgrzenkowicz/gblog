<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\String;

use App\Domain\Shared\ValueObject\String\CategoriesVO;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CategoriesVOTest extends TestCase
{
    public static function provideValidLengthCategories(): array
    {
        return [
            [
                'categories' => sprintf('%s,%s', $category1 = uniqid(), $category2 = uniqid()),
                'categoriesString' => sprintf('%s,%s', $category1, $category2),
            ],
            [
                'categories' => sprintf('%s,%s,%s', $category1 = uniqid(), $category2 = uniqid(), $category3 = uniqid()),
                'categoriesString' => sprintf('%s,%s,%s', $category1, $category2, $category3),
            ],
            [
                'categories' => sprintf('%s,%s,%s', $category1 = uniqid(), $category2 = uniqid(), 'CAPITAL'),
                'categoriesString' => sprintf('%s,%s,%s', $category1, $category2, 'capital'),
            ],
        ];
    }

    #[DataProvider('provideValidLengthCategories')]
    public function testShouldConvertObjectToString(string $categories, string $categoriesString): void
    {
        // When
        $vo = $this->createInstanceUnderTest($categories);

        // Then
        $this->assertSame($vo->__toString(), $categoriesString);
    }

    public function testShouldReturnArray(): void
    {
        // When
        $vo = $this->createInstanceUnderTest($categories = sprintf('%s,%s',uniqid(), uniqid()));

        // Then
        $this->assertSame($categories, $vo->__toString());
    }

    public function testTest(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // When
        $this->createInstanceUnderTest(sprintf('%s,%s,%s,%s',uniqid(), uniqid(), uniqid(), uniqid()));
    }

    private function createInstanceUnderTest(string $categories): CategoriesVO
    {
        return new CategoriesVO($categories);
    }
}
