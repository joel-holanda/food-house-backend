<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductsController extends AbstractController
{
    #[Route(
        '/products',
        name: 'get_products',
        methods: ['GET']
    )]
    public function getProducts(ProductRepository $productRepository, Request $request)
    {
        $context = json_decode($request->getContent(), true);
        
        $products = $productRepository->productsForStore($context['store']);
        $data = [];

        foreach($products as $product)
        {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'store_id' => $product->getStore()->getId()
            ];
        }
        
        return new JsonResponse($data);
    }
}