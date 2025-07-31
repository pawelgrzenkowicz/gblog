<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query\Handler;

use App\Application\Article\Query\GetAdminArticles;
use App\Application\Article\Query\Handler\GetAdminArticlesHandler;
use App\Application\Article\Reader\AdminArticleDetailsReader;
use App\Tests\unit\_OM\Application\Article\View\AdminArticleDetailsViewMother;
use App\Tests\unit\_OM\Application\Shared\PaginationMother;
use App\Tests\unit\_OM\Application\Shared\SortMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetAdminArticlesHandlerTest extends TestCase
{
    private AdminArticleDetailsReader|MockObject $adminReader;

    protected function setUp(): void
    {
        $this->adminReader = $this->createMock(AdminArticleDetailsReader::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->adminReader,
        );
    }

    public function testShouldHandleAndExecuteMessage(): void
    {
        // Given
        $articles = [AdminArticleDetailsViewMother::createDefault()];
        $query = new GetAdminArticles(
            $pagination = PaginationMother::createDefault(),
            $sort = SortMother::createDefault()
        );

        $this->adminReader
            ->expects($this->once())
            ->method('all')
            ->with($pagination, $sort)
            ->willReturn($articles);

        $this->adminReader
            ->expects($this->once())
            ->method('count')
            ->willReturn($total = random_int(1, 10));

        // When
        $handler = $this->createInstanceUnderTest($this->adminReader);

        // Then
        $this->assertSame(['items' => $articles, 'total' => $total,], $handler->__invoke($query));
    }

    private function createInstanceUnderTest(AdminArticleDetailsReader $adminReader): GetAdminArticlesHandler
    {
        return new GetAdminArticlesHandler($this->adminReader);
    }
}
