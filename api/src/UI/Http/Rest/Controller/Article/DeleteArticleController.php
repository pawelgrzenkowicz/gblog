<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Article;

use App\Application\Article\Command\DeleteArticle;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Payload\UuidPayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class DeleteArticleController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $uuid = $request->attributes->get('uuid');

        $errors = (new UuidPayload(['uuid' => $uuid]))
            ->validate(Validation::createValidator());

        if ($errors) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $this->application->execute(
            new DeleteArticle(
                $uuid,
            )
        );

        return new Response(null, Response::HTTP_OK, [
                'Content-Type' => 'application/json'
            ]
        );
    }
}
