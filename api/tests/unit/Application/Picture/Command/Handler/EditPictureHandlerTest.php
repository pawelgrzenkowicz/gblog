<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Picture\Command\Handler;

use App\Application\Picture\Command\EditPicture;
use App\Application\Picture\Command\Handler\EditPictureHandler;
use App\Application\Picture\Exception\SavePictureException;
use App\Application\Shared\Error;
use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureFileStorage;
use App\Domain\Picture\PictureFormatterInterface;
use App\Domain\Picture\PictureRepositoryInterface;
use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\Object\PictureVO;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use SplFileInfo;

class EditPictureHandlerTest extends TestCase
{
    private PictureRepositoryInterface|MockObject $pictureRepository;
    private PictureFileStorage|MockObject $pictureFileStorage;
    private PictureFormatterInterface|MockObject $pictureFormatter;

    protected function setUp(): void
    {
        $this->pictureRepository = $this->createMock(PictureRepositoryInterface::class);
        $this->pictureFileStorage = $this->createMock(PictureFileStorage::class);
        $this->pictureFormatter = $this->createMock(PictureFormatterInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->pictureRepository,
            $this->pictureFileStorage,
            $this->pictureFormatter
        );
    }

    public function testShouldHandleAndExecuteMessageWhenNewPictureIsAdded(): void
    {
        // Given
        $source = 'dragon-ball-db2.jpg';
        $file = new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $source));
        $alt = uniqid();
        $extension = PictureExtension::PNG;
        $command = new EditPicture($source, $alt, $extension->value, $file);

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($source)
            ->willReturn(null);

        $this->pictureRepository
            ->expects($this->once())
            ->method('uniqueUuid')
            ->willReturn($uuid = Uuid::uuid4());

        $picture = new Picture(
            $uuid,
            $command->picture->alt,
            $command->picture->extension,
            $command->picture->source,
        );

        $this->pictureFileStorage
            ->expects($this->once())
            ->method('put')
            ->with($picture, $command->file);

        $this->pictureRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function(Picture $pictureSave) use ($picture) {

                    $this->assertEquals($picture, $pictureSave);

                    return true;
                })
            );

        $this->pictureFormatter
            ->expects($this->once())
            ->method('run')
            ->with($picture);

        // When
        $actual = $this->createInstanceUnderTest()->__invoke($command);

        // Then
        $this->assertEquals($picture, $actual);
    }

    public function testShouldHandleAndExecuteMessageWhenExistPictureIsChange(): void
    {
        // Given
        $pictureName = 'dragon-ball-db2';
        $source = sprintf('some/source/%s.jpg', $pictureName);
        $file = new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $source));
        $alt = uniqid();
        $extension = PictureExtension::PNG;
        $command = new EditPicture($source, $alt, $extension->value, $file);

//        $picture = new Picture(, new PictureVO($source, uniqid(), PictureExtension::JPG->value));

        $picture = new Picture(
            $uuid = Uuid::uuid4(),
            new PictureAltVO(uniqid()),
            PictureExtension::JPG,
            new PictureSourceVO($source),
        );

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($source)
            ->willReturn($picture);

        $this->pictureFormatter
            ->expects($this->once())
            ->method('remove')
            ->with($command->picture->source);

        $this->pictureFileStorage
            ->expects($this->once())
            ->method('put')
            ->with($picture, $command->file);

        $this->pictureRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function(Picture $pictureSave) use ($command, $pictureName) {

                    $this->assertSame($command->picture->alt, $pictureSave->alt());
                    $this->assertSame($command->picture->extension, $pictureSave->extension());
                    $this->assertSame($command->picture->source, $pictureSave->source());
                    $this->assertEquals($pictureName, $pictureSave->name()->value);

                    return true;
                })
            );

        $this->pictureFormatter
            ->expects($this->once())
            ->method('run')
            ->with($picture);

        // When
        $actual = $this->createInstanceUnderTest()->__invoke($command);

        // Then
        $this->assertEquals($picture, $actual);
    }

    public function testShouldThrowExceptionWhenSaveFailed(): void
    {
        // Given
        $source = 'dragon-ball-db2.jpg';
        $file = new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $source));
        $alt = uniqid();
        $extension = PictureExtension::PNG;
        $command = new EditPicture($source, $alt, $extension->value, $file);

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($source)
            ->willReturn(null);

        $this->pictureRepository
            ->expects($this->once())
            ->method('uniqueUuid')
            ->willReturn($uuid = Uuid::uuid4());

        $picture = new Picture(
            $uuid,
            $command->picture->alt,
            $command->picture->extension,
            $command->picture->source,
        );

        $this->pictureFileStorage
            ->expects($this->once())
            ->method('put')
            ->with($picture, $command->file);

        $this->pictureRepository
            ->expects($this->once())
            ->method('save')
            ->willThrowException(new SavePictureException());

        // Exception
        $this->expectException(SavePictureException::class);
        $this->expectExceptionMessage(Error::SAVE_PICTURE_EXCEPTION->value);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    private function createInstanceUnderTest(): EditPictureHandler
    {
        return new EditPictureHandler($this->pictureRepository, $this->pictureFileStorage, $this->pictureFormatter);
    }
}
