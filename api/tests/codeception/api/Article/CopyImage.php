<?php

declare(strict_types=1);

namespace App\Tests\codeception\api\Article;

use SplFileInfo;

trait CopyImage
{
    protected function copy(SplFileInfo $file, $newPath): void
    {
        $newDir = dirname($newPath);

        if (!is_dir($newDir)) {
            mkdir($newDir, 0777, true);
        }

        copy($file->getRealPath(), $newPath);
    }
}
