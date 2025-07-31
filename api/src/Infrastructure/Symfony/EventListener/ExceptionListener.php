<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\EventListener;

use App\Infrastructure\Http\Controller\ErrorResponse;
use App\Infrastructure\Symfony\Error;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[AsEventListener(priority: -16)]
final readonly class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
//        dump($event->getThrowable());
        [$message, $code] = $this->resolveException($event);
//        dump(2);

//        $message = $event->getThrowable()->getMessage();

//        dump($message);
//        exit;

        $event->setResponse(
            new JsonResponse((new ErrorResponse($message))->jsonSerialize(), $code)
        );
    }

    private function resolveException(ExceptionEvent $event): array
    {
        $message = Error::INTERNAL_ERROR->value;
        $code = 500;

        $exception = $event->getThrowable();

//        dump($exception->getStatusCode());

//        exit;
        while (null !== $exception) {
            if ($exception instanceof HttpException) {
                $message = $exception->getMessage();
                $code = $exception->getCode();

                break;
            }

            $exception = $exception->getPrevious();
        }

        return [$message, $code];
    }
}
