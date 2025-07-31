<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Symfony\Console;

use App\Application\Application;
use App\UI\Console\Command\User\CreateAdminUserCommand;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    private Application|MockObject $application;

    protected function setUp(): void
    {
        $this->application = $this->createMock(Application::class);
    }

    protected function tearDown(): void
    {
        unset(
            $this->application,
        );
    }

    public function testShouldCreateValidObject(): void
    {
        // Given
        $command = new CreateAdminUserCommand($this->application);

        // Then
        $this->assertInstanceOf(CreateAdminUserCommand::class, $command);
        $this->assertEquals('Create new Admin User', CreateAdminUserCommand::getDefaultDescription());
        $this->assertEquals('app:create-admin-user', $command->getName());
    }
}
