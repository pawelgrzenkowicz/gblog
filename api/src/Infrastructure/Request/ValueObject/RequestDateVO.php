<?php

declare(strict_types=1);

namespace App\Infrastructure\Request\ValueObject;

use Carbon\Carbon;
use Carbon\CarbonInterface;

final readonly class RequestDateVO
{
    public CarbonInterface $value;

    public function __construct(string $date)
    {
        $this->value = Carbon::create($date);
    }

    public function toAtom(): string
    {
        return $this->value->toAtomString();
    }
}
