<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Article;

use App\Application\Article\Query\GetAdminArticles;
use App\Application\Article\Query\GetAdminArticlesMongo;
use App\Application\Shared\Pagination;
use App\Application\Shared\Sort;
use App\Infrastructure\Http\Controller\Controller;
use App\Infrastructure\Http\Controller\PaginationResponse;
use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetAdminArticlesController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $query = $request->query->all();

        $result = $this->application->ask(
            new GetAdminArticles(
//            new GetAdminArticlesMongo(
                new Pagination(
                    $page = !empty($query['page']) ? (int)$query['page'] : 1,
                    !empty($query['limit']) ? (int)$query['limit'] : 10,
                ),
                new Sort(
                    'publication_date',
                    'desc'
                )
            )
        );

        return empty($result['items'])
            ? throw new NotFoundException(ErrorType::ARTICLE_NOT_FOUND->value)
            : new Response(
                json_encode(new PaginationResponse($result['items'], $page, $result['total'])),
                Response::HTTP_OK,
                ['Content-Type' => 'application/json']
            );
    }
}
