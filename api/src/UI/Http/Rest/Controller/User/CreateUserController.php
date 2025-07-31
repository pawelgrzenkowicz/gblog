<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\User;

use App\Application\User\Command\CreateUser;
use App\Domain\Shared\Enum\Role;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Payload\User\CreateUserPayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class CreateUserController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        if ($errors = (new CreateUserPayload($content))->validate(Validation::createValidator())) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $uuid = $this->application->execute(
            new CreateUser(
                $content['email'],
                $content['nickname'],
                $content['password'],
                Role::FREE_USER
            )
        );

        return new Response(null, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json',
            'Location' => $uuid,
        ]);
    }
}
