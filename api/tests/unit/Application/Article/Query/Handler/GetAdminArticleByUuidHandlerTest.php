<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Article\Query\Handler;

use App\Application\Article\Query\GetAdminArticleByUuid;
use App\Application\Article\Query\Handler\GetAdminArticleByUuidHandler;
use App\Application\Article\Reader\AdminArticleDetailsReader;
use App\Tests\unit\_OM\Application\Article\View\AdminArticleDetailsViewMother;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class GetAdminArticleByUuidHandlerTest extends TestCase
{
    private AdminArticleDetailsReader|MockObject $adminArticleDetailsReader;

    protected function setUp(): void
    {
        $this->adminArticleDetailsReader = $this->createMock(AdminArticleDetailsReader::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->adminArticleDetailsReader,
        );
    }

    public function testShouldHandleAndExecuteMessageAndIncreaseViews(): void
    {
        // Given
        $uuid = Uuid::uuid4();
        $article = AdminArticleDetailsViewMother::createDefault();
        $query = new GetAdminArticleByUuid($uuid->toString());

        $this->adminArticleDetailsReader
            ->expects($this->once())
            ->method('byUuid')
            ->with($uuid)
            ->willReturn($article);

        // When
        $handle = $this->createInstanceUnderTest()->__invoke($query);

        // Then
        $this->assertSame($article, $handle);
    }

    private function createInstanceUnderTest(): GetAdminArticleByUuidHandler
    {
        return new GetAdminArticleByUuidHandler($this->adminArticleDetailsReader);
    }
}
