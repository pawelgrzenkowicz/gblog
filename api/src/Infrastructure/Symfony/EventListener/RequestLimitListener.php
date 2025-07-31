<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\EventListener;

use App\Infrastructure\Request\RequestManagerInterface;
use App\Infrastructure\Symfony\Error;
use Carbon\Carbon;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

#[AsEventListener(priority: 2)]
final readonly class RequestLimitListener
{
    public function __construct(private RequestManagerInterface $requestManager) {}

    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$config = $this->requestManager->routeExist($route = $request->attributes->get('_route'))) {
            return;
        }
        if ($this->requestManager->allow($ip = $request->getClientIp(), $route, $config)) {
            $this->requestManager->add($ip, $route, (new Carbon(null, 'Europe/Warsaw'))->toAtomString());
            return;
        }

        throw new TooManyRequestsHttpException(message: Error::TOO_MANY_REQUESTS->value, code: 429);
    }
}
