<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Picture;

use App\Application\Picture\Command\DeletePicture;
use App\Infrastructure\Http\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeletePictureController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $this->application->execute(
            new DeletePicture(
                $request->attributes->get('source')
            )
        );

        return new Response(null, Response::HTTP_OK, ['Content-Type' => 'application/json']);
    }
}
