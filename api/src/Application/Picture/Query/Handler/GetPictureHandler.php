<?php

declare(strict_types=1);

namespace App\Application\Picture\Query\Handler;

use App\Application\Picture\Query\GetPicture;

use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureRepositoryInterface;

final readonly class GetPictureHandler
{
    public function __construct(
        private PictureRepositoryInterface $pictureRepository
    ) {}

    public function __invoke(GetPicture $command): ?Picture
    {
        return $this->pictureRepository->bySource($command->pictureSource);
    }
}
