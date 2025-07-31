<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Picture\Query;

use App\Application\Picture\Query\GetPicture;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use PHPUnit\Framework\TestCase;

class GetPictureTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $source = new PictureSourceVO('some/path/nazwa.jpg');

        // When
        $actual = $this->createInstanceUnderTest($source->__toString());

        // Then
        $this->assertEquals($source, $actual->pictureSource);
    }

    private function createInstanceUnderTest(string $source): GetPicture
    {
        return new GetPicture($source);
    }
}
