<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\User;

use App\Application\User\Command\DeleteUser;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Payload\UuidPayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class DeleteUserController extends Controller
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

        $this->application->execute(
            new DeleteUser($uuid)
        );

        return new Response(null, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
