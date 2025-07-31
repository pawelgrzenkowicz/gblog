<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Article;

use App\Application\Article\Command\UpdateArticle;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Payload\Article\UpdateArticlePayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class UpdateArticleController extends Controller
{
    private const FILE_KEY = 'mainPictureFile';

    public function __invoke(Request $request): Response
    {
        $uuid = $request->attributes->get('uuid');
        $data = $request->request->all();
        $files = $request->files->all();

        $errors = (new UpdateArticlePayload(array_merge($data, $files)))
            ->validate(Validation::createValidator());

        if ($errors) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        $this->application->execute(
            new UpdateArticle(
                $uuid,
                $files[self::FILE_KEY] ?? null,
                $data['mainPicture']['source'],
                $data['mainPicture']['alt'],
                $data['contents']['he'],
                $data['contents']['she'],
                (bool) $data['ready']['he'],
                (bool) $data['ready']['she'],
                $data['slug'],
                $data['title'],
                $data['categories'],
                (int) $data['views'],
                (bool) $data['removed'],
                $data['createDate'],
                $data['publicationDate'],
            )
        );

        return new Response(null, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
