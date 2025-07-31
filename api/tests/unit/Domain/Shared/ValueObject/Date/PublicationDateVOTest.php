<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Date;

use App\Domain\Shared\ValueObject\Date\PublicationDateVO;
use PHPUnit\Framework\TestCase;

class PublicationDateVOTest extends TestCase
{
    public function testShouldFormatDate(): void
    {
        // When
        $vo = $this->createInstanceUnderTest('2023-06-30T17:40:00+00:00');

        // Then
        $this->assertSame($vo->formattedDate(), '2023-06-30T17:40');
    }

    private function createInstanceUnderTest(string $date): PublicationDateVO
    {
        return new PublicationDateVO($date);
    }
}
