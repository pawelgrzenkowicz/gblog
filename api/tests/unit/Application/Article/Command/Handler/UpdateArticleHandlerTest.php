<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Command\Handler;

use App\Application\Article\Command\Handler\UpdateArticleHandler;
use App\Application\Article\Command\UpdateArticle;
use App\Application\Article\Exception\ArticleNotFoundException;
use App\Application\Article\Exception\ArticleSlugAlreadyExistException;
use App\Application\Picture\Exception\PictureSourceAlreadyExistException;
use App\Application\Shared\Error;
use App\Domain\Article\Article;
use App\Domain\Article\ArticleRepositoryInterface;
use App\Domain\Picture\PictureFileStorage;
use App\Domain\Picture\PictureFormatterInterface;
use App\Domain\Picture\PictureRepositoryInterface;
use App\Domain\Shared\Enum\PictureExtension;
use App\Domain\Shared\ValueObject\String\PictureAltVO;
use App\Domain\Shared\ValueObject\String\PictureNameVO;
use App\Domain\Shared\ValueObject\String\PictureSourceVO;
use App\Tests\unit\_OM\Domain\ArticleMother;
use App\Tests\unit\_OM\Domain\PictureMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use SplFileInfo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpdateArticleHandlerTest extends TestCase
{
    private ArticleRepositoryInterface|MockObject $articleRepository;
    private PictureRepositoryInterface|MockObject $pictureRepository;
    private PictureFileStorage|MockObject $fileStorage;
    private PictureFormatterInterface|MockObject $pictureFormatter;

    protected function setUp(): void
    {
        $this->articleRepository = $this->createMock(ArticleRepositoryInterface::class);
        $this->pictureRepository = $this->createMock(PictureRepositoryInterface::class);
        $this->fileStorage = $this->createMock(PictureFileStorage::class);
        $this->pictureFormatter = $this->createMock(PictureFormatterInterface::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->articleRepository,
            $this->pictureRepository,
            $this->fileStorage,
            $this->pictureFormatter,
        );
    }

    public function testShouldHandleAndExecuteMessageWhenChangeMainPictureSource(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $command = new UpdateArticle(
            $uuid->toString(),
            $file = new UploadedFile(__DIR__ . '/../../../../../../public/core/dragon-ball-db.jpg', 'dragon-ball-db.jpg'),
            sprintf('some/path/%s', $pictureName = uniqid()),
            uniqid(),
            uniqid(),
            uniqid(),
            true,
            true,
            $slug = uniqid(),
            uniqid(),
            uniqid(),
            0,
            true,
            '1994-06-30T17:40:00+00:00',
            '1994-06-30T17:40'
        );

        $this->articleRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn($oldArticle = ArticleMother::createDefault());

        $oldPicture = clone $oldArticle->mainPicture();

        $this->articleRepository
            ->expects($this->once())
            ->method('bySlug')
            ->with($slug)
            ->willReturn(null);

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with($newSource = new PictureSourceVO(sprintf('%s.%s', $command->source->value, $extension = 'jpg')))
            ->willReturn(null);

        $this->articleRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Article $article) use (
                    $command,
                    $newSource,
                    $extension,
                    $pictureName
                ) {
                    $this->assertSame($command->alt, $article->mainPicture()->alt());
                    $this->assertEquals($newSource, $article->mainPicture()->source());
                    $this->assertEquals(PictureExtension::fromString($extension), $article->mainPicture()->extension());
                    $this->assertEquals(new PictureNameVO($pictureName), $article->mainPicture()->name());
                    $this->assertSame($command->contentHe, $article->contentHe());
                    $this->assertSame($command->contentShe, $article->contentShe());
                    $this->assertSame($command->readyHe, $article->readyHe());
                    $this->assertSame($command->slug, $article->slug());
                    $this->assertSame($command->title, $article->title());
                    $this->assertSame($command->categories, $article->categories());
                    $this->assertSame($command->views, $article->views());
                    $this->assertSame($command->removed, $article->removed());
                    $this->assertSame($command->createDate, $article->createDate());
                    $this->assertSame($command->publicationDate, $article->publicationDate());
                    
                    return true;
                })
            );

        $this->fileStorage
            ->expects($this->once())
            ->method('put')
            ->with($picture = $oldArticle->mainPicture(), $file);

        $this->pictureFormatter
            ->expects($this->once())
            ->method('run')
            ->with($picture);

        $this->pictureFormatter
            ->expects($this->once())
            ->method('remove')
            ->with($oldArticle->mainPicture()->source()->value);

        $this->fileStorage
            ->expects($this->once())
            ->method('delete')
            ->with($oldPicture);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    public function testShouldHandleAndExecuteMessageWhenDontChangeMainPictureSource(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $oldArticle = ArticleMother::createDefault();
        $file = new SplFileInfo(__DIR__ . '/../../../../../../public/core/dragon-ball-db.jpg');
        $command = new UpdateArticle(
            $uuid->toString(),
            null,
            'some/url/name',
            uniqid(),
            uniqid(),
            uniqid(),
            true,
            true,
            $slug = uniqid(),
            uniqid(),
            uniqid(),
            0,
            true,
            '1994-06-30T17:40:00+00:00',
            '1994-06-30T17:40'
        );

        $this->articleRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn($oldArticle);

        $oldPicture = clone $oldArticle->mainPicture();

        $this->articleRepository
            ->expects($this->once())
            ->method('bySlug')
            ->with($slug)
            ->willReturn(null);

        $this->fileStorage
            ->expects($this->once())
            ->method('get')
            ->with($oldArticle->mainPicture())
            ->willReturn($file);

        $this->articleRepository
            ->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(function (Article $article) use ($command) {
                    $this->assertSame($command->alt, $article->mainPicture()->alt());
                    $this->assertEquals($command->source->value . '.jpg', $article->mainPicture()->source());
                    $this->assertEquals(PictureExtension::fromString('jpg'), $article->mainPicture()->extension());
                    $this->assertEquals(new PictureNameVO('name'), $article->mainPicture()->name());
                    $this->assertSame($command->contentHe, $article->contentHe());
                    $this->assertSame($command->contentShe, $article->contentShe());
                    $this->assertSame($command->readyHe, $article->readyHe());
                    $this->assertSame($command->slug, $article->slug());
                    $this->assertSame($command->title, $article->title());
                    $this->assertSame($command->categories, $article->categories());
                    $this->assertSame($command->views, $article->views());
                    $this->assertSame($command->removed, $article->removed());
                    $this->assertSame($command->createDate, $article->createDate());
                    $this->assertSame($command->publicationDate, $article->publicationDate());

                    return true;
                })
            );

        $this->fileStorage
            ->expects($this->once())
            ->method('put')
            ->with($picture = $oldArticle->mainPicture(), $file);

        $this->pictureFormatter
            ->expects($this->once())
            ->method('run')
            ->with($picture);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    public function testShouldThrowExceptionWhenArticleDoesNotExist(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $command = new UpdateArticle(
            $uuid->toString(),
            null,
            'some/url/name',
            uniqid(),
            uniqid(),
            uniqid(),
            true,
            true,
            uniqid(),
            uniqid(),
            uniqid(),
            0,
            true,
            '1994-06-30T17:40:00+00:00',
            '1994-06-30T17:40'
        );

        $this->articleRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn(null);

        // Exception
        $this->expectException(ArticleNotFoundException::class);
        $this->expectExceptionMessage(Error::ARTICLE_DOES_NOT_EXIST->value);
        $this->expectExceptionCode(404);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    public function testShouldThrowExceptionWhenNewSlugAlreadyExistInDatabase(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $command = new UpdateArticle(
            $uuid->toString(),
            null,
            'some/url/name',
            uniqid(),
            uniqid(),
            uniqid(),
            true,
            true,
            uniqid(),
            uniqid(),
            uniqid(),
            0,
            true,
            '1994-06-30T17:40:00+00:00',
            '1994-06-30T17:40'
        );

        $this->articleRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn(ArticleMother::createDefault());

        $this->articleRepository
            ->expects($this->once())
            ->method('bySlug')
            ->with($command->slug)
            ->willReturn(ArticleMother::createDefaultWithSlug($command->slug));

        // Exception
        $this->expectException(ArticleSlugAlreadyExistException::class);
        $this->expectExceptionMessage(Error::ARTICLE_SLUG_ALREADY_EXIST->value);
        $this->expectExceptionCode(422);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    public function testShouldThrowExceptionWhenNewPictureSourceAlreadyExist(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $picture = PictureMother::create(
            Uuid::uuid4(),
            new PictureAltVO(uniqid()),
            PictureExtension::JPG,
            new PictureSourceVO(sprintf('some/path/%s.jpg', uniqid()))
        );

        $command = new UpdateArticle(
            $uuid->toString(),
            $file = new UploadedFile(__DIR__ . '/../../../../../../public/core/dragon-ball-db.jpg', 'dragon-ball-db.jpg'),
            'some/url/name',
            uniqid(),
            uniqid(),
            uniqid(),
            true,
            true,
            $slug = uniqid(),
            uniqid(),
            uniqid(),
            0,
            true,
            '1994-06-30T17:40:00+00:00',
            '1994-06-30T17:40'
        );

        $this->articleRepository
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn(ArticleMother::createDefaultWithPicture($picture));

        $this->articleRepository
            ->expects($this->once())
            ->method('bySlug')
            ->with($slug)
            ->willReturn(null);

        $this->pictureRepository
            ->expects($this->once())
            ->method('bySource')
            ->with(new PictureSourceVO(sprintf('%s.%s', $command->source->value, 'jpg')))
            ->willReturn(PictureMother::createDefault());

        // Exception
        $this->expectException(PictureSourceAlreadyExistException::class);
        $this->expectExceptionMessage(Error::PICTURE_SOURCE_ALREADY_EXIST->value);
        $this->expectExceptionCode(422);

        // When
        $this->createInstanceUnderTest()->__invoke($command);
    }

    private function createInstanceUnderTest(): UpdateArticleHandler
    {
        return new UpdateArticleHandler(
            $this->articleRepository,
            $this->pictureRepository,
            $this->fileStorage,
            $this->pictureFormatter
        );
    }
}
