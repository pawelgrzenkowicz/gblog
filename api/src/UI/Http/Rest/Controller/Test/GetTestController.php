<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Test;

use App\Application\Test\Query\GetTest;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetTestController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $result = $this->application->ask(
            new GetTest()
        );

        return empty($result)
            ? throw new NotFoundException(ErrorType::TEST_NOT_FOUND->value)
            : new Response(json_encode($result), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
