<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Picture\Command\Handler;

use App\Application\Picture\Command\AddPicture;
use App\Application\Picture\Command\Handler\AddPictureHandler;
use App\Application\Picture\Exception\PictureSourceAlreadyExistException;
use App\Application\Picture\Exception\SavePictureException;
use App\Application\Shared\Error;
use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureFileStorage;
use App\Domain\Picture\PictureFormatterInterface;
use App\Domain\Picture\PictureRepositoryInterface;
use App\Domain\Shared\Enum\PictureExtension;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use SplFileInfo;

class AddPictureHandlerTest extends TestCase
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

    public static function providePictures(): array
    {
        $name1 = 'dragon-ball-db.jpg';
        $name2 = 'dragon-ball-db2.jpg';

        return [
            [
                'source' => $name1,
                'file' => new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $name1)),
                'alt' => uniqid(),
                'extension' => PictureExtension::JPG,
            ],
            [
                'source' => $name2,
                'file' => new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $name2)),
                'alt' => uniqid(),
                'extension' => PictureExtension::PNG,
            ],
        ];
    }

    #[DataProvider('providePictures')]
    public function testShouldHandleAndExecuteMessage(
        string $source,
        SplFileInfo $file,
        string $alt,
        PictureExtension $extension
    ): void
    {
        // Given
        $command = new AddPicture($source, $alt, $extension->value, $file);

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

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($command->picture->source)
            ->willReturn(null);

        $this->pictureFileStorage
            ->expects($this->once())
            ->method('put')
            ->with($picture, $command->file);

        $this->pictureRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Picture $picture) use ($uuid) {
                    $this->assertSame($uuid->toString(), $picture->uuid->toString());

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

    public function testShouldThrowExceptionWhenSourceAlreadyExist(): void
    {
        // Given
        $source = 'dragon-ball-db2.jpg';
        $file = new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $source));
        $alt = uniqid();
        $extension = PictureExtension::PNG;

        $command = new AddPicture($source, $alt, $extension->value, $file);

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

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($command->picture->source)
            ->willReturn(null);

        $this->pictureFileStorage
            ->expects($this->once())
            ->method('put')
            ->with($picture, $command->file);

        $this->pictureRepository
            ->expects($this->once())
            ->method('save')
            ->with($picture)
            ->willThrowException(new SavePictureException());

        $this->pictureFileStorage
            ->expects($this->once())
            ->method('delete')
            ->with($picture);

        // Exception
        $this->expectException(SavePictureException::class);
        $this->expectExceptionMessage(Error::SAVE_PICTURE_EXCEPTION->value);
        $this->expectExceptionCode(422);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    public function testShouldThrowExceptionWhenSaveFileFailed(): void
    {
        // Given
        $source = 'dragon-ball-db2.jpg';
        $file = new SplFileInfo(__DIR__ . sprintf('/../../../../public/core/%s', $source));
        $alt = uniqid();
        $extension = PictureExtension::PNG;

        $command = new AddPicture($source, $alt, $extension->value, $file);

        $picture = new Picture(
            Uuid::uuid4(),
            $command->picture->alt,
            $command->picture->extension,
            $command->picture->source,
        );

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($command->picture->source)
            ->willReturn($picture);

        // Exception
        $this->expectException(PictureSourceAlreadyExistException::class);
        $this->expectExceptionMessage(Error::PICTURE_SOURCE_ALREADY_EXIST->value);
        $this->expectExceptionCode(422);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    private function createInstanceUnderTest(): AddPictureHandler
    {
        return new AddPictureHandler($this->pictureRepository, $this->pictureFileStorage, $this->pictureFormatter);
    }
}
