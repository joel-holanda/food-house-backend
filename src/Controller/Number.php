<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Number extends AbstractController
{
    #[Route(
        '/number',
        name: 'number',
    )]
    public function home(): Response
    {
        return $this->render('number/numberHome.html.twig');
    }


    #[Route(
    '/number/{num}',
     name: 'number_num',
     methods: ['GET', 'HEAD'],
     requirements: ['num' => '\d+'])]
    public function show(int $num): Response
    {
        return $this->render('number/numberChosen.html.twig', [
            'number' => $num,
        ]);
    }
}       