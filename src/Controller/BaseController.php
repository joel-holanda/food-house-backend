<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class BaseController extends AbstractController
{
    public function verifyParamRouter(Request $request, array $param): JsonResponse | array
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


}