<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query;

use App\Application\Article\Query\GetVisibleArticle;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Tests\unit\_OM\Application\Shared\SortMother;
use PHPUnit\Framework\TestCase;

class GetVisibleArticleTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $query = $this->createInstanceUnderTest(
            $pagination = new Pagination(1, 10),
            $sort = SortMother::createDefault()
        );

        // Then
        $this->assertSame($pagination, $query->pagination);
        $this->assertSame($sort, $query->sort);
    }

    private function createInstanceUnderTest(Pagination $pagination, Sort $sort): GetVisibleArticle
    {
        return new GetVisibleArticle($pagination, $sort);
    }
}
