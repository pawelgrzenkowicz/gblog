<?php

declare(strict_types=1);

namespace App\Tests\unit\Domain\Shared\ValueObject\Date;

use App\Domain\Shared\ValueObject\Date\CreateDateVO;
use PHPUnit\Framework\TestCase;

class CreateDateVOTest extends TestCase
{
    public function testShouldFormatDate(): void
    {
        // When
        $vo = $this->createInstanceUnderTest($atomDate = '2023-06-30T17:40:00+00:00');

        // Then
        $this->assertSame($vo->toAtom(), $atomDate);
    }

    private function createInstanceUnderTest(string $date): CreateDateVO
    {
        return new CreateDateVO($date);
    }
}
