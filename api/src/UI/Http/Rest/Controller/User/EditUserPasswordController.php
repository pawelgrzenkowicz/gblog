<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\User;

use App\Application\User\Command\EditUserPassword;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Payload\User\EditUserPasswordPayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class EditUserPasswordController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $content = json_decode($request->getContent(), true);

        $validate = [];

        if ($content['password'] !== $content['plainPassword']) {
            $validate = ['password' => [ErrorType::PASSWORDS_NOT_THE_SAME->value]];
        }

        $errors = array_merge_recursive($validate, (new EditUserPasswordPayload($content))->validate(Validation::createValidator()));

        if ($errors) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $this->application->execute(
            new EditUserPassword(
                $content['oldPassword'],
                $content['plainPassword'],
            )
        );

        return new Response(null, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
