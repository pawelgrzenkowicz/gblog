<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller\Picture;

use App\Infrastructure\Http\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GetPictureController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $imagePath = __DIR__ . '/../../../../../../images/cache/' . $request->attributes->get('source');

        if (!file_exists($imagePath)) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $imageContent = file_get_contents($imagePath);
        $mimeType = mime_content_type($imagePath);

        return new Response($imageContent, Response::HTTP_OK, ['Content-Type' => $mimeType]);
    }
}
