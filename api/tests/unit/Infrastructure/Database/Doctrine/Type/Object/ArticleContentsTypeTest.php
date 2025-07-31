<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Database\Doctrine\Type\Object;

use App\Domain\Shared\ValueObject\Object\ContentsVO;
use App\Domain\Shared\ValueObject\String\ContentVO;
use App\Infrastructure\Database\Doctrine\Type\Object\ArticleContentsType;
use App\Infrastructure\Symfony\Error;
use Doctrine\ODM\MongoDB\Types\Type;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ArticleContentsTypeTest extends TestCase
{
    protected function setUp(): void
    {
        Type::registerType(ArticleContentsType::getTypeName(), ArticleContentsType::class);
    }

    public function testShouldConvertToDatabaseValue(): void
    {
        // Then
        $this->assertSame(
            ['he' => $he = uniqid(), 'she' => $she = uniqid()],
            $this->createInstanceUnderTest()->convertToDatabaseValue($this->createContentsVO($he, $she))
        );
    }

    public function testShouldConvertToPHPValue(): void
    {
        // Then
        $this->assertEquals(
            $this->createContentsVO($he = uniqid(), $she = uniqid()),
            $this->createInstanceUnderTest()->convertToPHPValue(['he' => $he, 'she' => $she])
        );
    }

    public function testShouldThrowExceptionWhenDataToSaveInDatabaseIsInvalid(): void
    {
        // Exception
        $this->expectException(UnprocessableEntityHttpException::class);
        $this->expectExceptionMessage(Error::INVALID_DATA->value);

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
        $this->expectExceptionMessage(Error::INVALID_DATA->value);

        // When
        $this->createInstanceUnderTest()->convertToPHPValue(uniqid());
    }

    public function testShouldReturnValidTypeName()
    {
        $this->assertSame('article_contents_type', $this->createInstanceUnderTest()::getTypeName());
    }

    private function createInstanceUnderTest(): ArticleContentsType
    {
        return ArticleContentsType::getType(ArticleContentsType::getTypeName());
    }

    private function createContentsVO(string $he, string $she): ContentsVO
    {
        return new ContentsVO(new ContentVO($he), new ContentVO($she));
    }
}
