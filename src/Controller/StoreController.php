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
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;


class StoreController extends BaseController
{
    #[Route(
        '/store/{id}',
        name: 'get_store',
        methods: ['GET']
    )]
    public function index(StoreRepository $storeRepository, Request $request,NormalizerInterface $normalize, int $id)
    {
        $store = $storeRepository->storeId($id);
        $jsonStore = $normalize->normalize($store[0],'json');

        return new JsonResponse($jsonStore, 200);
    }

    #[Route(
        '/store',
        name: 'post_store',
        methods: ['POST']
    )]
    public function addStore(Request $request, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $form = $this->createForm(StoreType::class, new StoreModel());
        $errors = $this->verifyForm($form, $request);
        if($errors) return $errors;

        $store = new Store();

        $serializer->deserialize($request->getContent(), Store::class, 'json', context: ['object_to_populate' => $store]);
        $em->persist($store);
        $em->flush();

        $jsonStore = $serializer->serialize($store, 'json'
    );

        return new Response($jsonStore);
    }
}
