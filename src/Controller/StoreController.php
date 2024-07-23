<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Cookie;

class StoreController extends AbstractController
{

    #[Route('/store', name: 'app_store')]
    public function index(): Response
    {
        $response = new Response(
            "ojoel",
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        $response->headers->setCookie(Cookie::create('foot', 'bar'));
        return $response;
    }
}
