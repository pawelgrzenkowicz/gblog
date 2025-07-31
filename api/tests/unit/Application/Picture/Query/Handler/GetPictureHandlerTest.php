<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Picture\Query\Handler;

use App\Application\Picture\Query\GetPicture;
use App\Application\Picture\Query\Handler\GetPictureHandler;
use App\Domain\Picture\PictureRepositoryInterface;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use App\Tests\unit\_OM\Domain\PictureMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetPictureHandlerTest extends TestCase
{
    private PictureRepositoryInterface|MockObject $pictureRepository;

    protected function setUp(): void
    {
        $this->pictureRepository = $this->createMock(PictureRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->pictureRepository,
        );
    }

    public function testShouldHandleAndExecuteMessage(): void
    {
        // Given
        $picture = PictureMother::createDefault();
        $source = new PictureSourceVO('some/url/name.jpg');
        $query = new GetPicture($source->__toString());

        // When
        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($query->pictureSource)
            ->willReturn($picture);

        $handler = $this->createInstanceUnderTest($this->pictureRepository);


        // Then
        $this->assertSame($picture, $handler->__invoke($query));
    }

    private function createInstanceUnderTest(PictureRepositoryInterface $pictureRepository): GetPictureHandler
    {
        return new GetPictureHandler($pictureRepository);
    }
}
