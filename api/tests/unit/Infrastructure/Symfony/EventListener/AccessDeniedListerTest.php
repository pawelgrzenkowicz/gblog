<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Symfony\EventListener;

use App\Infrastructure\Symfony\EventListener\AccessDeniedListener;
use App\UI\Http\Rest\Error\ErrorType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccessDeniedListerTest extends TestCase
{
    public function testShouldReturnValidResponseWhenAccessDenied(): void
    {
        // Given
        $request = $this->createMock(Request::class);
        $accessDeniedException = $this->createMock(AccessDeniedException::class);

        // When
        $actual = $this->createInstanceUnderTest()->handle($request, $accessDeniedException);

        // Then
        $this->assertEquals(json_encode(['type' => ErrorType::ACCESS_DENIED]), $actual->getContent());
        $this->assertEquals(Response::HTTP_FORBIDDEN, $actual->getStatusCode());
        $this->assertEquals('application/json', $actual->headers->get('Content-Type'));
    }

    private function createInstanceUnderTest(): AccessDeniedListener
    {
        return new AccessDeniedListener();
    }
}
