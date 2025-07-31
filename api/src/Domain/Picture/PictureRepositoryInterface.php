<?php

declare(strict_types=1);

namespace App\Domain\Picture;

use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use Ramsey\Uuid\UuidInterface;

interface PictureRepositoryInterface
{
    public function bySource(PictureSourceVO $source): ?Picture;

    public function delete(Picture $picture): void;

    public function save(Picture $picture): void;

    public function uniqueUuid(): UuidInterface;
}
