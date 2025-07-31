<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Object;

final readonly class ArticleReadyVO
{
    public bool $he;

    public bool $she;

    public function __construct(bool $he = false, bool $she = false)
    {
        $this->he = $he;
        $this->she = $she;
    }

    public function isReady(): bool
    {
        return $this->he && $this->she;
    }

    public function toArray(): array
    {
        return [
            'he' => $this->he,
            'she' => $this->she,
        ];
    }
}
