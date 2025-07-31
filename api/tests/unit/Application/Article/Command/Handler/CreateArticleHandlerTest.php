<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Command\Handler;

use App\Application\Article\Command\CreateArticle;
use App\Application\Article\Command\Handler\CreateArticleHandler;
use App\Application\Article\Exception\ArticleSlugAlreadyExistException;
use App\Domain\Article\ArticleRepositoryInterface;
use App\Domain\Shared\ValueObject\String\SlugVO;
use App\Tests\unit\_OM\Domain\ArticleMother;
use App\Tests\unit\_OM\Domain\PictureMother;
use App\UI\Http\Rest\Error\ErrorType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CreateArticleHandlerTest extends TestCase
{
    private const string DEFAULT_DATE = '1994-06-30T17:40:00+00:00';
    
    private ArticleRepositoryInterface|MockObject $articleRepository;

    protected function setUp(): void
    {
        $this->articleRepository = $this->createMock(ArticleRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->articleRepository,
            $this->savePicture,
        );
    }

    public function testShouldHandleAndExecuteMessage(): void
    {
        // Given
        $picture = PictureMother::createDefault();
        $contentHe = uniqid();
        $contentShe = uniqid();
        $readyHe = true;
        $readyShe = true;
        $slug = 'DEFAULT_SLUG';
        $title = 'DEFAULT_TITLE';
        $removed = false;
        $createDate = self::DEFAULT_DATE;
        $publicationDate = self::DEFAULT_DATE;

        $this->articleRepository
            ->expects($this->once())
            ->method('uniqueUuid')
            ->willReturn($uuid = Uuid::uuid4());
        
        $command = new CreateArticle(
            $picture,
            $contentHe,
            $contentShe,
            $readyHe,
            $readyShe,
            $slug,
            $title,
            uniqid(),
            0,
            $removed,
            $createDate,
            $publicationDate,
        );

        $article = ArticleMother::create(
            $uuid,
            $command->picture,
            $command->contentHe,
            $command->contentShe,
            $command->readyHe,
            $command->readyShe,
            $command->slug,
            $command->title,
            $command->categories,
            $command->views,
            $command->removed,
            $command->createDate,
            $command->publicationDate
        );

        $this->articleRepository
            ->expects($this->once())
            ->method('bySlug')
            ->with($slug)
            ->willReturn(null);

        $this->articleRepository
            ->expects($this->once())
            ->method('save')
            ->with($article);

        // When
        $handle = $this->createInstanceUnderTest()->__invoke($command);

        // Then
        $this->assertSame($uuid->toString(), $handle);
    }

    public function testShouldThrowExceptionWhenArticleSlugAlreadyExist(): void
    {
        // Given
        $picture = PictureMother::createDefault();
        $contentHe = uniqid();
        $contentShe = uniqid();
        $readyHe = true;
        $readyShe = true;
        $slug = 'DEFAULT_SLUG';
        $title = 'DEFAULT_TITLE';
        $removed = false;
        $createDate = self::DEFAULT_DATE;
        $publicationDate = self::DEFAULT_DATE;

        $command = new CreateArticle(
            $picture,
            $contentHe,
            $contentShe,
            $readyHe,
            $readyShe,
            $slug,
            $title,
            uniqid(),
            0,
            $removed,
            $createDate,
            $publicationDate,
        );

        $this->articleRepository
            ->expects($this->once())
            ->method('bySlug')
            ->with($slug)
            ->willReturn(ArticleMother::createDefaultWithSlug(new SlugVO($slug)));

        // Exception
        $this->expectException(ArticleSlugAlreadyExistException::class);
        $this->expectExceptionMessage(ErrorType::ARTICLE_SLUG_ALREADY_EXIST->value);
        $this->expectExceptionCode(422);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    private function createInstanceUnderTest(): CreateArticleHandler
    {
        return new CreateArticleHandler($this->articleRepository);
    }
}
