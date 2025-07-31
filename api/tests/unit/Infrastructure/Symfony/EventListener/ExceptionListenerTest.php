<?php

declare(strict_types=1);

namespace App\Tests\unit\Infrastructure\Symfony\EventListener;

use App\Application\Test\Exception\TestNotFoundException;
use App\Infrastructure\Symfony\EventListener\ExceptionListener;
use App\UI\Http\Rest\Error\ErrorType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionListenerTest extends TestCase
{
    public static function provideErrorTypeAndStatusCode(): array
    {
        return [
            [
                'statusCode' => 400,
                'errorType' => ErrorType::INTERNAL_ERROR->value,
            ],
            [
                'statusCode' => 404,
                'errorType' => ErrorType::INVALID_DATA->value,
            ],
            [
                'statusCode' => 404,
                'errorType' => ErrorType::INVALID_PASSWORD_UPPERCASE->value,
            ],
            [
                'statusCode' => 404,
                'errorType' => 'ERROR_TYPE_NOT_CONTAIN_THIS_MESSAGE',
            ],
        ];
    }

    #[DataProvider('provideErrorTypeAndStatusCode')]
    public function testShouldSetExceptionWithEnumMessage(int $statusCode, string $errorType): void
    {
        // Given
        $httpException = new HttpException($statusCode, $errorType, code: $statusCode);

        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);
        $exceptionEvent = new ExceptionEvent($kernel, $request, random_int(400, 422), $httpException);

        // When
        $this->createInstanceUnderTest()->__invoke($exceptionEvent);

        // Then
        $this->assertSame($statusCode, $exceptionEvent->getResponse()->getStatusCode());
        $this->assertEquals(sprintf('{"type":"%s"}', $errorType), $exceptionEvent->getResponse()->getContent());
    }

    public function testShouldSetPreviousException(): void
    {
        // Given
        $statusCode = 404;
        $errorType = 'TEST_NOT_FOUND';

        $httpException = new TestNotFoundException();
        $exception1 = new BadRequestException(previous: $httpException);

        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);
        $exceptionEvent = new ExceptionEvent($kernel, $request, random_int(400, 422), $exception1);

        // When
        $this->createInstanceUnderTest()->__invoke($exceptionEvent);

        // Then
        $this->assertSame($statusCode, $exceptionEvent->getResponse()->getStatusCode());
        $this->assertEquals(sprintf('{"type":"%s"}', $errorType), $exceptionEvent->getResponse()->getContent());
    }

    public function testShouldSetTwoPreviousException(): void
    {
        // Given
        $statusCode = 404;
        $errorType = 'TEST_NOT_FOUND';

        $httpException = new TestNotFoundException();
        $exception1 = new BadRequestException(previous: $httpException);
        $exception2 = new BadRequestException(previous: $exception1);

        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);
        $exceptionEvent = new ExceptionEvent($kernel, $request, random_int(400, 422), $exception2);

        // When
        $this->createInstanceUnderTest()->__invoke($exceptionEvent);

        // Then
        $this->assertSame($statusCode, $exceptionEvent->getResponse()->getStatusCode());
        $this->assertEquals(sprintf('{"type":"%s"}', $errorType), $exceptionEvent->getResponse()->getContent());
    }

    public function testShouldSetHttpExceptionWithCode500(): void
    {
        // Given
        $exception1 = new BadRequestException(previous: null);

        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);
        $exceptionEvent = new ExceptionEvent($kernel, $request, random_int(400, 422), $exception1);

        // When
        $this->createInstanceUnderTest()->__invoke($exceptionEvent);

        // Then
        $this->assertSame(500, $exceptionEvent->getResponse()->getStatusCode());
        $this->assertEquals(
            sprintf('{"type":"%s"}', ErrorType::INTERNAL_ERROR->value),
            $exceptionEvent->getResponse()->getContent()
        );
    }

    private function createInstanceUnderTest(): ExceptionListener
    {
        return new ExceptionListener();
    }
}
