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
        $json = array("Joel", "Holanda", "Rocha");
        return $this->json($json);
    }


    #[Route(
    '/number/{num}',
     name: 'number_num',
     methods: ['GET', 'HEAD'],
     requirements: ['num' => '\d+'])]
    public function show(int $num): Response
    {
        echo '<input type="box"></input>';

        return $this->render('number/numberChosen.html.twig', [
            'number' => $num,
        ]);
    }
}       