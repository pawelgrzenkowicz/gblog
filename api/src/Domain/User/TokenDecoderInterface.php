<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\ValueObject\String\EmailVO;

interface TokenDecoderInterface
{
    public function decodeEmail(): ?EmailVO;
}
