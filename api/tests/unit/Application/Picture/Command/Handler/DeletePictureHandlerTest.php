<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Picture\Command\Handler;

use App\Application\Picture\Command\DeletePicture;
use App\Application\Picture\Command\Handler\DeletePictureHandler;
use App\Application\Picture\Exception\PictureNotFoundException;
use App\Application\Shared\Error;
use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureFileStorage;
use App\Domain\Picture\PictureFormatterInterface;
use App\Domain\Picture\PictureRepositoryInterface;
use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class DeletePictureHandlerTest extends TestCase
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

    public function testShouldHandleAndExecuteMessage(): void
    {
        // Given
        $command = new DeletePicture($source = uniqid());
        $alt = uniqid();
        $extension = PictureExtension::PNG;
        $picture = new Picture(
            $uuid = Uuid::uuid4(),
            new PictureAltVO($alt),
            $extension,
            new PictureSourceVO($source)
        );

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($source)
            ->willReturn($picture);

        $this->pictureRepository
            ->expects($this->once())
            ->method('delete')
            ->with($picture);

        $this->pictureFileStorage
            ->expects($this->once())
            ->method('delete')
            ->with($picture);

        $this->pictureFormatter
            ->expects($this->once())
            ->method('remove')
            ->with($picture->source()->__toString());

        // When
        $this->createInstanceUnderTest()->__invoke($command);

        // Then
        $this->assertFalse($this->doesNotPerformAssertions());
    }

    public function testShouldThrowExceptionWhenPictureNotFound(): void
    {
        // Given
        $command = new DeletePicture($source = uniqid());

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($source)
            ->willReturn(null);

        // Exception
        $this->expectException(PictureNotFoundException::class);
        $this->expectExceptionMessage(Error::PICTURE_NOT_FOUND->value);
        $this->expectExceptionCode(404);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    private function createInstanceUnderTest(): DeletePictureHandler
    {
        return new DeletePictureHandler($this->pictureRepository, $this->pictureFileStorage, $this->pictureFormatter);
    }
}
