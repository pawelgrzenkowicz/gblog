<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Object;

use App\Domain\Shared\ValueObject\Object\ArticleReadyVO;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ArticleReadyVOTest extends TestCase
{
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
    public function testShouldCreateValidObject(bool $he, bool $she, bool $expectedHe, bool $expectedShe): void
    {
        // When
        $contentsVO = $this->createInstanceUnderTest($he, $she);

        // Then
        $this->assertSame($expectedHe, $contentsVO->toArray()['he']);
        $this->assertSame($expectedShe, $contentsVO->toArray()['she']);
    }

    public static function provideReadyScenarios(): array
    {
        return [
            [
                'he' => true,
                'she' => true,
                'expected' => true,
            ],
            [
                'he' => false,
                'she' => true,
                'expected' => false,
            ],
            [
                'he' => true,
                'she' => false,
                'expected' => false,
            ],
        ];
    }

    #[DataProvider('provideReadyScenarios')]
    public function testShouldCheckIfArticleIsReady(bool $he, bool $she, bool $expected): void
    {
        // When
        $contentsVO = $this->createInstanceUnderTest($he, $she);

        // Then
        $this->assertSame($expected, $contentsVO->isReady());
    }

    public function testShouldCheckIfArticleIsNotReadyWhenNoArguments(): void
    {
        // Then
        $this->assertSame(false, (new ArticleReadyVO())->isReady());
    }

    public function testShouldCheckIfArticleIsNotReadySetWhenOnlyHeArgument(): void
    {
        // Then
        $this->assertSame(false, (new ArticleReadyVO(true))->isReady());
    }

    public function testShouldCheckIfArticleIsNotReadySetWhenOnlySheArgument(): void
    {
        // Then
        $this->assertSame(false, (new ArticleReadyVO(she: true))->isReady());
    }

    private function createInstanceUnderTest(bool $he, bool $she): ArticleReadyVO
    {
        return new ArticleReadyVO($he, $she);
    }
}
