<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Test\Command;

use App\Application\Test\Command\DeleteTest;
use Codeception\PHPUnit\TestCase;
use Ramsey\Uuid\Uuid;

class DeleteTestTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // Given
        $uuid = Uuid::uuid4();

        // Then
        $this->assertEquals($uuid, (new DeleteTest($uuid->toString()))->uuid);
    }
}
