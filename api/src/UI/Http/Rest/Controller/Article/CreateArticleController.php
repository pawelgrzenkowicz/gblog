<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Article;

use App\Application\Article\Command\CreateArticle;
use App\Application\Picture\Command\AddPicture;
use App\Application\Picture\Command\DeletePicture;
use App\Domain\Picture\Picture;
use App\Infrastructure\Http\Controller\Controller;
use App\Infrastructure\Http\Controller\ErrorResponse;
use App\UI\Http\Rest\Error\ErrorType;
use App\UI\Http\Rest\Payload\Article\CreateArticlePayload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class CreateArticleController extends Controller
{
    private const FILE_KEY = 'mainPictureFile';

    public function __invoke(Request $request): Response
    {
        $files = $request->files->all();
        $data = $request->request->all();

        $errors = (new CreateArticlePayload(array_merge($data, $files)))
            ->validate(Validation::createValidator());

        if ($errors) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }


        $file = $files[self::FILE_KEY];

        /** @var Picture $picture */
        $picture = $this->application->execute(
            new AddPicture(
                sprintf('%s.%s', $data['mainPicture']['source'], $extension = $file->guessExtension()),
                $data['mainPicture']['alt'],
                $extension,
                $file
            )
        );

        try {
            $uuid = $this->application->execute(
                new CreateArticle(
                    $picture,
                    $data['contents']['he'],
                    $data['contents']['she'],
                    (bool) $data['ready']['he'],
                    (bool) $data['ready']['she'],
                    $data['slug'],
                    $data['title'],
                    $data['categories'],
                    (int)$data['views'],
                    (bool)$data['removed'],
                    $data['createDate'],
                    $data['publicationDate'],
                )
            );

            return new Response(null, Response::HTTP_CREATED, [
                    'Content-Type' => 'application/json',
                    'Location' => $uuid,
                ]
            );
        } catch (\Throwable $e) {
            $this->application->execute(
                new DeletePicture(str_replace('original/', '', $picture->source()->value))
            );

            if ($e->getPrevious()) {
                $message = $e->getPrevious()->getMessage();
            } else {
                $message = ErrorType::INTERNAL_ERROR->value;
            }

            $x = (new ErrorResponse($message))->jsonSerialize();


            return new Response(
                json_encode((new ErrorResponse($message))->jsonSerialize()),
                $e->getCode(),
                ['Content-Type' => 'application/json',]
            );
        }
    }
}
