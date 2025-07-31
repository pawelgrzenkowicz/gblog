<?php

declare(strict_types=1);

namespace App\Tests\unit\Application\Picture\Command;

use App\Application\Picture\Command\DeletePicture;
use PHPUnit\Framework\TestCase;

class DeletePictureTest extends TestCase
{
    public function testShouldCreateValidObject(): void
    {
        // When
        $command = $this->createInstanceUnderTest($source = uniqid());

        // Then
        $this->assertEquals($source, $command->pictureSource->__toString());
    }

    private function createInstanceUnderTest(string $source): DeletePicture
    {
        return new DeletePicture($source);
    }
}
