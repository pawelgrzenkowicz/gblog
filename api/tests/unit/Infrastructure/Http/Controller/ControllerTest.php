<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Http\Controller;

use App\Application\Application;
use App\UI\Http\Rest\Controller\Test\GetTestController;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    private Application|MockObject $application;

    protected function setUp(): void
    {
        $this->application = $this->createMock(Application::class);
    }

    public function testShouldCreateValidObject(): void
    {
        // Then
        $this->assertInstanceOf(GetTestController::class, new GetTestController($this->application));
    }
}
