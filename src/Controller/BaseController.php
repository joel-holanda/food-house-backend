<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class BaseController extends AbstractController
{
    public function verifyParamRouter(Request $request, array $param)
    {
        $context = json_decode($request->getContent(), true);
        var_dump(array_keys($context));exit;
        $paramRequest = array_keys($context);
        $haveParamDuplicate = array_count_values($paramRequest) > 1 ? true : false;

        //adjust error, him come in function and not stop but return Response to class that the call
        if (!isset($context)) {
            return new Response('Por favor, envie os parâmetros do body necessários', Response::HTTP_BAD_REQUEST);
        }

        foreach($context as $body)
        {
            if(!in_array($body, $param)) echo "Erradoo";exit;
            if($haveParamDuplicate) echo "Tem parametro duplicado, pode n man, faz direito";exit;
        }

        return $context; 
    }


}