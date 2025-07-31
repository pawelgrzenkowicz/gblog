<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Test;

use App\Application\Test\Command\UpdateTest;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Payload\Test\UpdateTestPayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class UpdateTestController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);
        $uuid = $request->attributes->get('uuid');

        $errors = (new UpdateTestPayload(array_merge(['uuid' => $uuid], $content)))
            ->validate(Validation::createValidator());

        if ($errors) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $this->application->execute(
            new UpdateTest(
                $uuid,
                $content['name'],
                $content['number'],
            ));

        return new Response(null, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
