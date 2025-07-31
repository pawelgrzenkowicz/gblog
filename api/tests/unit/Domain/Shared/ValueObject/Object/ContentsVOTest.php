<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Object;

use App\Domain\Shared\ValueObject\Object\ContentsVO;
use App\Domain\Shared\ValueObject\String\ContentVO;
use PHPUnit\Framework\TestCase;

class ContentsVOTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $he = new ContentVO(uniqid());
        $she = new ContentVO(uniqid());

        // When
        $contentsVO = $this->createInstanceUnderTest($he, $she);

        // Then
        $this->assertSame($he->value, $contentsVO->toArray()['he']);
        $this->assertSame($she->value, $contentsVO->toArray()['she']);
    }

    private function createInstanceUnderTest(ContentVO $he, ContentVO $she): ContentsVO
    {
        return new ContentsVO($he, $she);
    }
}
