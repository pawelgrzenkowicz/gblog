<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Picture;

use App\Application\Picture\Command\AddPicture;
use App\Domain\Picture\Picture;
use App\Infrastructure\Http\Controller\Controller;
use App\UI\Http\Rest\Payload\Picture\AddPicturePayload;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class AddPictureController extends Controller
{
    private const string ORIGINAL_FOLDER_NAME = 'original';
    private const string PICTURE = 'picture';

    public function __invoke(Request $request): Response
    {
        $files = $request->files->all();
        $data = $request->request->all();

        $errors = (new AddPicturePayload(array_merge($data, $files)))
            ->validate(Validation::createValidator());

        if ($errors) {
            return new Response(
                json_encode(['errors' => $errors]),
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json']
            );
        }

        /** @var Picture $picture */
        $picture = $this->application->execute(
            new AddPicture(
                sprintf('%s.%s', $data['source'], $extension = $files[self::PICTURE]->guessExtension()),
                $data['alt'],
                $extension,
                $files[self::PICTURE]
            )
        );

        return new Response(null, Response::HTTP_CREATED, [
            'Content-Type' => 'application/json',
            'Location' => sprintf('%s/%s', self::ORIGINAL_FOLDER_NAME, $picture->source()->value),
        ]);
    }
}
