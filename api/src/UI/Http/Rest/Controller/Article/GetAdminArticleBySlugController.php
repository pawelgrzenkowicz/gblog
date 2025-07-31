<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Article;

use App\Application\Article\Query\GetAdminArticleBySlug;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Exception\NotFoundException;
use App\UI\Http\Rest\Payload\Article\GetArticleBySlugPayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class GetAdminArticleBySlugController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $slug = $request->attributes->get('slug');

        $errors = (new GetArticleBySlugPayload(['slug' => $slug]))
            ->validate(Validation::createValidator());

        if ($errors) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $result = $this->application->ask(
            new GetAdminArticleBySlug($slug)
        );

        return empty($result)
            ? throw new NotFoundException(ErrorType::ARTICLE_NOT_FOUND->value)
            : new Response(json_encode($result), Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
