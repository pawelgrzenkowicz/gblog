<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Iterable;

use App\Domain\Shared\ValueObject\Iterable\CategoriesVO;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class CategoriesVOTest extends TestCase
{
    public static function provideValidLengthCategories(): array
    {
        return [
            [
                'categories' => [$category1 = uniqid(), $category2 = uniqid()],
                'categoriesString' => sprintf('%s,%s', $category1, $category2),
            ],
            [
                'categories' => [$category1 = uniqid(), $category2 = uniqid(), $category3 = uniqid()],
                'categoriesString' => sprintf('%s,%s,%s', $category1, $category2, $category3),
            ],
            [
                'categories' => [$category1 = uniqid(), $category2 = uniqid(), 'CAPITAL'],
                'categoriesString' => sprintf('%s,%s,%s', $category1, $category2, 'capital'),
            ],
        ];
    }

    #[DataProvider('provideValidLengthCategories')]
    public function testShouldConvertObjectToString(array $categories, string $categoriesString): void
    {
        // When
        $vo = $this->createInstanceUnderTest($categories);

        // Then
        $this->assertSame($vo->toString(), $categoriesString);
    }

    public function testShouldReturnArray(): void
    {
        // When
        $vo = $this->createInstanceUnderTest($categories = [uniqid(), uniqid()]);

        // Then
        $this->assertSame($categories, $vo->toArray());
    }

    public function testTest(): void
    {
        // Exception
        $this->expectException(InvalidArgumentException::class);

        // When
        $this->createInstanceUnderTest([uniqid(), uniqid(), uniqid(), uniqid()]);
    }

    private function createInstanceUnderTest(array $categories): CategoriesVO
    {
        return new CategoriesVO($categories);
    }
}
