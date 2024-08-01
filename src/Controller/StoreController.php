<?php

namespace App\Controller;

use App\Repository\StoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class StoreController extends AbstractController
{

    #[Route('/store', name: 'app_store')]
    public function index(StoreRepository $storeRepository): JsonResponse
    {

        $stores = $storeRepository->findByExampleField();
        $name = [];
        foreach($stores as $store) {
            $name[] = $store->getName();
        }
        return new JsonResponse([
            'name'=> $name,
        ]);
    }
}
