<?php

declare(strict_types=1);

namespace App\Infrastructure\Filesystem;

use SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;

final readonly class Directory implements DirectoryInterface
{
    public function __construct(private Filesystem $filesystem, private string $directory)
    {
        $this->filesystem->mkdir($this->directory);
    }

    public function get(string $path): ?SplFileInfo
    {
        $path = $this->path($path);

        return file_exists($path) ? new SplFileInfo($path) : null;
    }

    public function link(string $path, SplFileInfo $file): void
    {
        $this->filesystem->symlink($file->getPathname(), $this->path($path));
    }

    public function put(string $path, SplFileInfo $file): void
    {
//        dump($this->path($path));
//        exit;
        $this->filesystem->copy($file->getPathname(), $this->path($path));
    }

    public function remove(string $path): void
    {
        $this->filesystem->remove($this->path($path));
    }

    private function path(string $path): string
    {
        return Path::makeAbsolute($path, $this->directory);
    }
}
