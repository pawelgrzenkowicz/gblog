<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query;

use App\Application\Article\Query\GetArticleBySlug;
use PHPUnit\Framework\TestCase;

class GetArticleBySlugTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $query = $this->createInstanceUnderTest($slug = uniqid());

        // Then
        $this->assertSame($slug, $query->slug->__toString());
    }

    private function createInstanceUnderTest(string $slug): GetArticleBySlug
    {
        return new GetArticleBySlug($slug);
    }
}
