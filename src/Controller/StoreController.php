<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class StoreController extends BaseController
{
    #[Route('/store', name: 'get_store', methods: ['GET'])]
    public function index(StoreRepository $storeRepository, Request $request): JsonResponse
    {
        $param = $this->verifyParamRouter($request, ['store']);
        if($param instanceof JsonResponse) return $param;

        $stores = $storeRepository->storeId($param['store']);

        $data = [];
        foreach ($stores as $store) {
            $data[] = [
                'id' => $store->getId(),
                'name' => $store->getName(),
                'description' => $store->getDescription(),
                'cnpj' => $store->getCnpj()
            ];
        }

        return new JsonResponse(json_encode($data[0]));
    }

    #[Route(
        '/store',
        name: 'post_store',
        methods: ['POST']
    )]
    public function addStore(Request $request, EntityManagerInterface $em): Response
    {
        $data = $this->verifyParamRouter($request, ['name', 'cnpj', 'storeContact', 'description', ]);

        $store = new Store;
        $store->setName($data['nome']);
        $store->setCnpj($data['cnpj']);

        $em->persist($store);
        $em->flush();

        return new Response('Loja add com sucesso. Nome: ' . $data['nome']);
    }
}
