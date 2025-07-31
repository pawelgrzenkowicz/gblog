<?php

declare(strict_types=1);

namespace App\Infrastructure\Filesystem;

use SplFileInfo;

interface DirectoryInterface
{
    public function get(string $path): ?SplFileInfo;

    public function link(string $path, SplFileInfo $file): void;

    public function put(string $path, SplFileInfo $file): void;

    public function remove(string $path): void;
}
