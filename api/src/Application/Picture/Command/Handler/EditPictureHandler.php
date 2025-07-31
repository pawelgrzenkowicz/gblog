<?php

declare(strict_types=1);

namespace App\Application\Picture\Command\Handler;

use App\Application\Picture\Command\EditPicture;
use App\Application\Picture\Exception\SavePictureException;
use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureFileStorage;
use App\Domain\Picture\PictureFormatterInterface;
use App\Domain\Picture\PictureRepositoryInterface;
use App\Domain\Shared\ValueObject\String\PictureNameVO;
use Throwable;

final readonly class EditPictureHandler
{
    public function __construct(
        private PictureRepositoryInterface $pictureRepository,
        private PictureFileStorage $fileStorage,
        private PictureFormatterInterface $formatter,
    ) {}

    // Nie używać tego - może spowodować problemy ze zdjęciami
    public function __invoke(EditPicture $command): Picture
    {
        if ($picture = $this->pictureRepository->bySource($command->picture->source)) {
            $this->formatter->remove($picture->source()->__toString());

            $picture->update([
                'alt' => $command->picture->alt,
                'extension' => $command->picture->extension,
                'source' => $command->picture->source,
                'name' => new PictureNameVO($picture->pictureName($command->picture->source->value)),
            ]);
        } else {
            $picture = new Picture(
                $this->pictureRepository->uniqueUuid(),
                $command->picture->alt,
                $command->picture->extension,
                $command->picture->source,
            );
        }

        $this->fileStorage->put($picture, $command->file);

        try {
            $this->pictureRepository->save($picture);
        } catch (Throwable $error) {
            throw new SavePictureException();
        }

        $this->formatter->run($picture);

        return $picture;
    }
}
