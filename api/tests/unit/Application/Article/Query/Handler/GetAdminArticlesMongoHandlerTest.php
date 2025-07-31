<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query\Handler;

use App\Application\Article\Query\GetAdminArticlesMongo;
use App\Application\Article\Query\Handler\GetAdminArticlesMongoHandler;
use App\Application\Article\Reader\AdminArticleDetailsReader;
use App\Infrastructure\Article\Reader\AdminArticlesDetailsMongoReader;
use App\Tests\unit\_OM\Application\Article\View\AdminArticleDetailsViewMother;
use App\Tests\unit\_OM\Application\Shared\PaginationMother;
use App\Tests\unit\_OM\Application\Shared\SortMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetAdminArticlesMongoHandlerTest extends TestCase
{
    private AdminArticlesDetailsMongoReader|MockObject $adminReader;

    protected function setUp(): void
    {
        $this->adminReader = $this->createMock(AdminArticlesDetailsMongoReader::class);
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
        $query = new GetAdminArticlesMongo(
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

    private function createInstanceUnderTest(AdminArticlesDetailsMongoReader $adminReader): GetAdminArticlesMongoHandler
    {
        return new GetAdminArticlesMongoHandler($this->adminReader);
    }
}
