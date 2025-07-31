<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Command\Handler;

use App\Application\Article\Command\Handler\UndeleteArticleHandler;
use App\Application\Article\Command\UndeleteArticle;
use App\Application\Article\Exception\ArticleNotFoundException;
use App\Application\Shared\Error;
use App\Domain\Article\Article;
use App\Domain\Article\ArticleRepositoryInterface;
use App\Tests\unit\_OM\Domain\ArticleMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UndeleteArticleHandlerTest extends TestCase
{
    private ArticleRepositoryInterface|MockObject $articleRepository;

    protected function setUp(): void
    {
        $this->articleRepository = $this->createMock(ArticleRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->articleRepository,
        );
    }

    public function testShouldRemoveArticle(): void
    {
        // Given
        $article = ArticleMother::createDefault();

        // When
        $this->articleRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid = $article->uuid)
            ->willReturn($article);

        $this->articleRepository
            ->expects($this->once())
            ->method('undelete')
            ->with(
                $this->callback(function (Article $article) use ($uuid) {

                    $this->assertSame($uuid, $article->uuid);

                    return true;
                })
            );

        $this->createInstanceUnderTest()->__invoke(new UndeleteArticle($article->uuid->toString()));
    }

    public function testShouldThrowExceptionWheUserNotFound(): void
    {
        // Given
        $uuid = Uuid::uuid4();

        // When
        $this->articleRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn(null);

        // Exception
        $this->expectException(ArticleNotFoundException::class);
        $this->expectExceptionMessage(Error::ARTICLE_DOES_NOT_EXIST->value);
        $this->expectExceptionCode(404);

        // Then
        $this->createInstanceUnderTest()->__invoke(new UndeleteArticle($uuid->toString()));
    }

    private function createInstanceUnderTest(): UndeleteArticleHandler
    {
        return new UndeleteArticleHandler($this->articleRepository);
    }
}
