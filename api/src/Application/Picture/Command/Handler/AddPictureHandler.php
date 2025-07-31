<?php

declare(strict_types=1);

namespace App\Application\Picture\Command\Handler;

use App\Application\Picture\Command\AddPicture;
use App\Application\Picture\Exception\PictureSourceAlreadyExistException;
use App\Application\Picture\Exception\SavePictureException;
use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureFileStorage;
use App\Domain\Picture\PictureFormatterInterface;
use App\Domain\Picture\PictureRepositoryInterface;
use Throwable;

final readonly class AddPictureHandler
{
    public function __construct(
        private PictureRepositoryInterface $pictureRepository,
        private PictureFileStorage $fileStorage,
        private PictureFormatterInterface $formatter,
    ) {}

    public function __invoke(AddPicture $command): Picture
    {
        if ($this->pictureRepository->bySource($command->picture->source)) {
            throw new PictureSourceAlreadyExistException();
        }

        $picture = new Picture(
            $this->pictureRepository->uniqueUuid(),
            $command->picture->alt,
            $command->picture->extension,
            $command->picture->source,
        );

        $this->fileStorage->put($picture, $command->file);

        try {
            $this->pictureRepository->save($picture);
        } catch (Throwable $error) {
            $this->fileStorage->delete($picture);
            throw new SavePictureException();
        }

        $this->formatter->run($picture);

        return $picture;
    }
}
