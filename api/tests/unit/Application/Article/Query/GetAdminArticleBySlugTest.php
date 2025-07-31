<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query;

use App\Application\Article\Query\GetAdminArticleBySlug;
use PHPUnit\Framework\TestCase;

class GetAdminArticleBySlugTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $query = $this->createInstanceUnderTest($slug = uniqid());

        // Then
        $this->assertSame($slug, $query->slug->__toString());
    }

    private function createInstanceUnderTest(string $slug): GetAdminArticleBySlug
    {
        return new GetAdminArticleBySlug($slug);
    }
}
