<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Test;

use App\Application\Test\Query\GetSingleTest;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Exception\NotFoundException;
use App\UI\Http\Rest\Payload\UuidPayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class GetSingleTestController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $uuid = $request->attributes->get('uuid');

        if ($errors = (new UuidPayload(['uuid' => $uuid]))->validate(Validation::createValidator())) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $result = $this->application->ask(
            new GetSingleTest($uuid)
        );

        return empty($result)
            ? throw new NotFoundException(ErrorType::TEST_NOT_FOUND->value)
            : new Response(json_encode($result), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
