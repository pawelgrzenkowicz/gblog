<?php

declare(strict_types=1);

namespace App\Application\Picture\Command\Handler;

use App\Application\Picture\Command\DeletePicture;
use App\Application\Picture\Exception\PictureNotFoundException;
use App\Domain\Picture\PictureFileStorage;
use App\Domain\Picture\PictureFormatterInterface;
use App\Domain\Picture\PictureRepositoryInterface;

final readonly class DeletePictureHandler
{
    public function __construct(
        private PictureRepositoryInterface $pictureRepository,
        private PictureFileStorage $pictureFileStorage,
        private PictureFormatterInterface $pictureFormatter
    ) {}

    public function __invoke(DeletePicture $command): void
    {
        if (!$picture = $this->pictureRepository->bySource($command->pictureSource)) {
            throw new PictureNotFoundException();
        }

        $this->pictureRepository->delete($picture);

        $this->pictureFileStorage->delete($picture);

        $this->pictureFormatter->remove($picture->source()->__toString());
    }
}
