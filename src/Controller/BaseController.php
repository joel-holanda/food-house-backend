<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class BaseController extends AbstractController
{

    /**
     * @var SerializerInterface
     */
    public $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function verifyParamRouter(Request $request, array $param)
    {
        $context = json_decode($request->getContent(), true);

        if (!isset($context)) {
            return $this->getResponse('Por favor, envie os parâmetros do body necessários: ' . json_encode($param), 400);
        }

        $paramRequest = array_keys($context);
        $haveParamDuplicate = array_count_values($paramRequest) > 1 ? true : false;


        foreach($context as $body)
        {
            if(!in_array($body, $param)) $this->getResponse("Erradoo") ;
            if($haveParamDuplicate) $this->getResponse("Tem parametro duplicado, pode n man, faz direito");
        }

        return $context;
    }

    public function getResponse(string $message, int $status = 400)
    {
        return new JsonResponse($message, $status);
    }
    
    public function verifyForm($form, Request $request) 
    {
        if($request->getMethod() == 'POST') {
            $data = json_decode($request->getContent(), true);
        } else {
            $data = $request->query->all();
        }
        $form->submit($data);
        if (!$form->isValid()) {
            return new Response('Dados invalidos');
        }
        
    }

    public function responseApi($data) 
    {
        $serializer = new Serializer([new ObjectNormalizer()], []);

        $json = $serializer->normalize($data, 'json');

        return $json;
    }

}