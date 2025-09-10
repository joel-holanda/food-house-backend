<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class BaseController extends AbstractController
{

    public $serializer;

    public $em;

    public $normalizer;

    public function __construct(SerializerInterface $serializer, EntityManagerInterface $em, NormalizerInterface $normalizer)
    {
        $this->serializer = $serializer;
        $this->em = $em;
        $this->normalizer = $normalizer;
    }

    public function verifyForm($form, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if (!$form->isSubmitted() || !$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            return new Response(json_encode($errors), 400);
        }
    }
}
