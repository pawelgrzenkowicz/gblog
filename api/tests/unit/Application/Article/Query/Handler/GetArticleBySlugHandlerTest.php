<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query\Handler;

use App\Application\Article\Query\GetArticleBySlug;
use App\Application\Article\Query\Handler\GetArticleBySlugHandler;
use App\Application\Article\Reader\VisibleArticleReader;
use App\Domain\Article\Article;
use App\Domain\Article\ArticleRepositoryInterface;
use App\Domain\Shared\ValueObject\Number\ViewsVO;
use App\Tests\unit\_OM\Application\Article\View\ArticleViewMother;
use App\Tests\unit\_OM\Application\Article\View\VisibleArticleViewMother;
use App\Tests\unit\_OM\Domain\ArticleMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetArticleBySlugHandlerTest extends TestCase
{
    private VisibleArticleReader|MockObject $articleReader;
    private ArticleRepositoryInterface|MockObject $articleRepository;

    protected function setUp(): void
    {
        $this->articleReader = $this->createMock(VisibleArticleReader::class);
        $this->articleRepository = $this->createMock(ArticleRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->articleReader,
            $this->articleRepository,
        );
    }

    public function testShouldHandleAndExecuteMessageAndIncreaseViews(): void
    {
        // Given
        $article = VisibleArticleViewMother::createDefault();
        $query = new GetArticleBySlug($slug = 'DEFAULT_SLUG');

        $this->articleRepository
            ->expects($this->once())
            ->method('bySlug')
            ->with($query->slug)
            ->willReturn(ArticleMother::createDefaultWithViews(new ViewsVO(0)));

        $this->articleRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Article $article) {

                    $this->assertSame(1, $article->views()->toInteger());

                    return true;
                })
            );

        $this->articleReader
            ->expects($this->once())
            ->method('bySlug')
            ->with($slug)
            ->willReturn($article);

        // When
        $handle = $this->createInstanceUnderTest()->__invoke($query);

        // Then
        $this->assertSame($article, $handle);
    }

    public function testShouldHandleAndExecuteMessageAndReturnEmpty(): void
    {
        // Given
        $query = new GetArticleBySlug($slug = 'DEFAULT_SLUG');

        $this->articleRepository
            ->expects($this->once())
            ->method('bySlug')
            ->with($query->slug)
            ->willReturn(null);

        $this->articleReader
            ->expects($this->once())
            ->method('bySlug')
            ->with($slug)
            ->willReturn(null);

        // When
        $handle = $this->createInstanceUnderTest()->__invoke($query);

        // Then
        $this->assertSame(null, $handle);
    }

    private function createInstanceUnderTest(): GetArticleBySlugHandler
    {
        return new GetArticleBySlugHandler($this->articleReader, $this->articleRepository);
    }
}
