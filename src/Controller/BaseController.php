<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Form\FormInterface;

class BaseController extends AbstractController
{

    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->serializer = $doctrine;
    }

    public function verifyParamRouter(Request $request, array $param)
    {
        $context = json_decode($request->getContent(), true);

        if (!isset($context)) {
            return $this->getResponse('Por favor, envie os parâmetros do body necessários: ' . json_encode($param), 400);
        }

        $paramRequest = array_keys($context);
        $haveParamDuplicate = array_count_values($paramRequest) > 1 ? true : false;


        foreach ($context as $body) {
            if (!in_array($body, $param))
                $this->getResponse("Erradoo");
            if ($haveParamDuplicate)
                $this->getResponse("Tem parametro duplicado, pode n man, faz direito");
        }

        return $context;
    }

    public function getResponse(string $message, int $status = 400)
    {
        return new JsonResponse($message, $status);
    }

    public function verifyForm($form, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $form->submit($data);
        if (!$form->isSubmitted() || !$form->isValid()) {
            // Retorna os erros de validação em JSON
            $errors = [];
            foreach ($form->getErrors(true) as $error) {
                $errors[] = $error->getMessage();
            }
            return $this->json(['errors' => $errors], 400);
        }
    }

    public function responseApi($data)
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncode()]);

        $json = $serializer->serialize($data, 'json', ['groups' => ['order']]);
        //dd($json);
        return $json;
    }

    /**
     * Valida um formulário e lança uma exceção que interrompe a requisição, caso não seja válido
     *
     * @param FormInterface $form
     * @param Request $request
     */
    protected function validateForm(FormInterface $form, Request $request)
    {
        if ($request->getMethod() == 'GET') {
            $data = $request->query->all();
        } else {
            $data = json_decode($request->getContent(), true);
            if ($data === null) {
                return new Response('invalid_body_format', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
        if (!$form->isValid()) {
            return 'errado';
        }
    }
}
