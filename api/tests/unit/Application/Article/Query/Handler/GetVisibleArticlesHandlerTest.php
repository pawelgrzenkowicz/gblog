<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query\Handler;

use App\Application\Article\Query\GetVisibleArticle;
use App\Application\Article\Query\Handler\GetVisibleArticlesHandler;
use App\Application\Article\Reader\VisibleArticleReader;
use App\Tests\unit\_OM\Application\Article\View\VisibleArticleViewMother;
use App\Tests\unit\_OM\Application\Shared\PaginationMother;
use App\Tests\unit\_OM\Application\Shared\SortMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetVisibleArticlesHandlerTest extends TestCase
{
    private VisibleArticleReader|MockObject $visibleArticleReader;

    protected function setUp(): void
    {
        $this->visibleArticleReader = $this->createMock(VisibleArticleReader::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->visibleArticleReader,
        );
    }

    public function testShouldHandleAndExecuteMessage(): void
    {
        // Given
        $articles = [VisibleArticleViewMother::createDefault()];
        $query = new GetVisibleArticle(
            $pagination = PaginationMother::createDefault(),
            $sort = SortMother::createDefault()
        );

        $this->visibleArticleReader
            ->expects($this->once())
            ->method('all')
            ->with($pagination, $sort)
            ->willReturn($articles);

        $this->visibleArticleReader
            ->expects($this->once())
            ->method('count')
            ->willReturn($total = random_int(1, 10));

        // When
        $handler = $this->createInstanceUnderTest();

        // Then
        $this->assertSame(['items' => $articles, 'total' => $total,], $handler->__invoke($query));
    }

    private function createInstanceUnderTest(): GetVisibleArticlesHandler
    {
        return new GetVisibleArticlesHandler($this->visibleArticleReader);
    }
}
