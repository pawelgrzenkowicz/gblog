<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\EventListener;

use App\UI\Http\Rest\Error\ErrorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedListener implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException): ?Response
    {
        return new Response(
            json_encode(["type" => ErrorType::ACCESS_DENIED]),
            Response::HTTP_FORBIDDEN,
            ['Content-Type' => 'application/json']
        );
    }
}
