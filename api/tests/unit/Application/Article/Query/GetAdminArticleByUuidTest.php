<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query;

use App\Application\Article\Query\GetAdminArticleByUuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetAdminArticleByUuidTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $query = $this->createInstanceUnderTest($uuid = Uuid::uuid4()->toString());

        // Then
        $this->assertSame($uuid, $query->uuid->toString());
    }

    private function createInstanceUnderTest(string $uuid): GetAdminArticleByUuid
    {
        return new GetAdminArticleByUuid($uuid);
    }
}
