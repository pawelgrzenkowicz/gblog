<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Command;

use App\Application\Article\Command\UndeleteArticle;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UndeleteArticleTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $query = $this->createInstanceUnderTest($uuid = Uuid::uuid4()->toString());

        // Then
        $this->assertSame($uuid, $query->uuid->toString());
    }

    private function createInstanceUnderTest(string $uuid): UndeleteArticle
    {
        return new UndeleteArticle($uuid);
    }
}
