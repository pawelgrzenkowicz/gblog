<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\Object;

use App\Domain\Shared\ValueObject\Object\ArticleReadyVO;
use App\Infrastructure\Database\Doctrine\Type\Object\ArticleReadyType;
use App\UI\Http\Rest\Error\ErrorType;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ArticleReadyTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(ArticleReadyType::getTypeName(), ArticleReadyType::class);
    }

    public static function provideReadyValues(): array
    {
        return [
            [
                'he' => true,
                'she' => true,
                'expectedHe' => true,
                'expectedShe' => true,
            ],
            [
                'he' => false,
                'she' => false,
                'expectedHe' => false,
                'expectedShe' => false,
            ],

            [
                'he' => true,
                'she' => false,
                'expectedHe' => true,
                'expectedShe' => false,
            ],

            [
                'he' => false,
                'she' => true,
                'expectedHe' => false,
                'expectedShe' => true,
            ],
        ];
    }

    #[DataProvider('provideReadyValues')]
    public function testShouldConvertToDatabaseValue(bool $he, bool $she, bool $expectedHe, bool $expectedShe): void
    {
        // Then
        $this->assertSame(
            ['he' => $he, 'she' => $she],
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createArticleReadyVO($expectedHe, $expectedShe))
        );
    }

    #[DataProvider('provideReadyValues')]
    public function testShouldConvertToPHPValue(bool $he, bool $she, bool $expectedHe, bool $expectedShe): void
    {
        // Then
        $this->assertEquals(
            $this->createArticleReadyVO($expectedHe, $expectedShe),
            $this->createInstanceUnderTest()->convertToPHPValue(['he' => $he, 'she' => $she])
        );
    }

    public function testShouldThrowExceptionWhenDataToSaveInDatabaseIsInvalid(): void
    {
        // Exception
        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage(ErrorType::INVALID_DATA->value);

        // When
        $this->createInstanceUnderTest()->convertToDatabaseValue([null]);
    }

    public function testShouldReturnNullWhenNullIsInDatabase(): void
    {
        // Then
        $this->assertNull($this->createInstanceUnderTest()->convertToPHPValue(null));
    }

    public function testShouldThrowExceptionWhenValueIsNotArray(): void
    {
        // Exception
        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage(ErrorType::INVALID_DATA->value);

        // When
        $this->createInstanceUnderTest()->convertToPHPValue(uniqid());
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('article_ready_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): ArticleReadyType
    {
        return ArticleReadyType::getType(ArticleReadyType::getTypeName());
    }

    private function createArticleReadyVO(bool $he, bool $she): ArticleReadyVO
    {
        return new ArticleReadyVO($he, $she);
    }
}
