<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Date;

use Carbon\Carbon;
use Carbon\CarbonInterface;

final readonly class PublicationDateVO
{
    public const string DATE_FORMAT = 'Y-m-d\TH:i';

    public CarbonInterface $value;

    public function __construct(string $date)
    {
        $this->value = Carbon::create($date);
    }

    public function formattedDate(): string
    {
        return $this->value->format(self::DATE_FORMAT);
    }
}
