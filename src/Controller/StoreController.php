<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class StoreController extends AbstractController
{
    #[Route('/store', name: 'get_store', methods: ['GET'])]
    public function index(StoreRepository $storeRepository, Request $request): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        $stores = $storeRepository->storeIdOrAll($content['store']);
        $data = [];
        foreach ($stores as $store) {
            $data[] = [
                'id' => $store->getId(),
                'name' => $store->getName(),
                'description' => $store->getDescription(),
                'cnpj' => $store->getCnpj()
            ];
        }
        return new JsonResponse($data);
    }

    #[Route(
        '/store',
        name: 'post_store',
        methods: ['POST']
    )]
    public function addStore(Request $request, EntityManagerInterface $em): Response
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        $store = new Store;
        $store->setName($data['nome']);
        $store->setCnpj($data['cnpj']);

        $em->persist($store);
        $em->flush();

        return new Response('Loja add com sucesso. Nome: ' . $data['nome']);
    }
}
