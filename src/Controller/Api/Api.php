<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class Api extends AbstractController
{
    private ShortUrlService $shortUrlService;

    public function __construct(ShortUrlService $shortUrlService)
    {
        $this->shortUrlService = $shortUrlService;
    }

    public function parseShortUrl(Request $request): Response {
        $originalUrl = $this->shortUrlService->fetchOriginalLink($request->getBaseUrl());
        if(!$originalUrl){
            return new Response('', Response::HTTP_NOT_FOUND);
        }
        return new RedirectResponse($originalUrl);
    }

    public function createShortUrl(Request $request): Response
    {
        $urlToShorten = $request->attributes->get('url');   
        try {
            $shortUrl = $this->shortUrlService->create($urlToShorten);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'message' => "The provided URL is invalid",
            ], Response::HTTP_BAD_REQUEST);
        }
        $response = new \StdClass();
        $response->result = $shortUrl;
        return new JsonResponse($response, Response::HTTP_OK);
        
    }
}
