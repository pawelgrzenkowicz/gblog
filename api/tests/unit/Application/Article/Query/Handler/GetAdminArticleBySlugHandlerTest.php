<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query\Handler;

use App\Application\Article\Query\GetAdminArticleBySlug;
use App\Application\Article\Query\Handler\GetAdminArticleBySlugHandler;
use App\Application\Article\Reader\AdminArticleDetailsReader;
use App\Tests\unit\_OM\Application\Article\View\AdminArticleDetailsViewMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetAdminArticleBySlugHandlerTest extends TestCase
{
    private AdminArticleDetailsReader|MockObject $visibleArticleReader;

    protected function setUp(): void
    {
        $this->visibleArticleReader = $this->createMock(AdminArticleDetailsReader::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->visibleArticleReader,
        );
    }

    public function testShouldHandleAndExecuteMessageAndIncreaseViews(): void
    {
        // Given
        $article = AdminArticleDetailsViewMother::createDefault();
        $query = new GetAdminArticleBySlug($slug = 'DEFAULT_SLUG');

        $this->visibleArticleReader
            ->expects($this->once())
            ->method('bySlug')
            ->with($slug)
            ->willReturn($article);

        // When
        $handle = $this->createInstanceUnderTest()->__invoke($query);

        // Then
        $this->assertSame($article, $handle);
    }

    private function createInstanceUnderTest(): GetAdminArticleBySlugHandler
    {
        return new GetAdminArticleBySlugHandler($this->visibleArticleReader);
    }
}
