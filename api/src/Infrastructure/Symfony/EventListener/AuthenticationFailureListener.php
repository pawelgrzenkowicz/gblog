<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\EventListener;

use App\Infrastructure\Symfony\Error;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AuthenticationFailureListener
{
    public function __invoke(AuthenticationFailureEvent $event)
    {
        throw new BadRequestHttpException(Error::BAD_CREDENTIALS->value, code: 400);
    }
}
