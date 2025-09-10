<?php

namespace App\Controller;

use App\Form\Type\StoreType;
use App\Model\StoreModel;
use App\Repository\StoreRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Store;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StoreController extends BaseController
{
    #[Route(
        '/store/{id}',
        name: 'get_store',
        methods: ['GET']
    )]
    public function index(StoreRepository $storeRepository, Request $request, int $id)
    {
        $store = $storeRepository->storeId($id);
        $jsonStore = $this->normalizer->normalize($store,'json');

        return new JsonResponse($jsonStore, 200);
    }

    #[Route(
        '/store',
        name: 'post_store',
        methods: ['POST']
    )]
    public function addStore(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(StoreType::class, new StoreModel());
        $errors = $this->verifyForm($form, $request);
        if($errors) return $errors;
        $store = new Store();
        
        $this->serializer->deserialize($request->getContent(), Store::class, 'json', context: ['object_to_populate' => $store]);
        $em->persist($store);
        $em->flush();

        $jsonStore = $this->serializer->serialize($store, 'json');

        return new Response($jsonStore);
    }
}
