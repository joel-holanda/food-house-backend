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
        '/store',
        name: 'get_store',
        methods: ['GET']
    )]
    public function index(StoreRepository $storeRepository, Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $stores = $storeRepository->storeId($content['store']);
        $data = [];
        foreach ($stores as $store) {
            $data[] = [
                'id' => $store->getId(),
                'name' => $store->getName(),
                'description' => $store->getDescription(),
                'cnpj' => $store->getCnpj()
            ];
        }
        return new JsonResponse($data[0]);
    }

    #[Route(
        '/store',
        name: 'post_store',
        methods: ['POST']
    )]
    public function addStore(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(StoreType::class, new StoreModel());
        $this->verifyForm($form, $request);
        $data = json_decode($request->getContent(), true);
        $store = new Store();
        $store->setName($data['name']);
        $store->setCnpj($data['cnpj']);
        $store->setDescription($data['description']);
        $store->setEmail($data['email']);
        $store->setPhoto($data['photo'] ? $data['photo'] : null);
        $store->setStoreContact(null);
        $store->setAddress(null);

        $em->persist($store);
        $em->flush();

        return new Response('Loja add com sucesso. Nome: ' . $data['name']);
    }
}
