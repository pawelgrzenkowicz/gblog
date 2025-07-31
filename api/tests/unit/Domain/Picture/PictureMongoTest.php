<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Picture;

use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureMongo;
use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\Object\PictureVO;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Domain\Shared\ValueObject\String\UrlVO;
use App\Tests\unit\_OM\Domain\PictureMother;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PictureMongoTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $alt = uniqid();
        $source = uniqid();
        $extension = PictureExtension::JPG;

        // When
        $pictureClass = $this->createInstanceUnderTest($uuid->toString(), $source, $alt, $extension->value);

        // Then
        $this->assertInstanceOf(UuidInterface::class, $pictureClass->uuid);
        $this->assertEquals($uuid, $pictureClass->uuid);
        $this->assertSame($alt, $pictureClass->picture()->alt->__toString());
        $this->assertSame($source, $pictureClass->picture()->source->__toString());
        $this->assertSame($extension, $pictureClass->picture()->extension);
    }

    private function createInstanceUnderTest(
        string $uuid,
        string $source,
        string $alt,
        string $extension
    ): PictureMongo {
        return new PictureMongo(
            Uuid::fromString($uuid), new PictureVO($source, $alt, $extension)
        );
    }
}
