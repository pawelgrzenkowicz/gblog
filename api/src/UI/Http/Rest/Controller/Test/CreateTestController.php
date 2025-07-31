<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Test;

use App\Application\Test\Command\CreateTest;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Payload\Test\CreateTestPayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class CreateTestController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        if ($errors = (new CreateTestPayload($content))->validate(Validation::createValidator())) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $uuid = $this->application->execute(
            new CreateTest(
                $content['name'],
                $content['number']
            ),
        );

        return new Response(null, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json',
            'Location' => $uuid,
        ]);
    }
}
