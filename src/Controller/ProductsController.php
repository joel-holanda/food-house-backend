<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

{
class ProductsController extends BaseController
    #[Route(
        '/products',
        name: 'get_products',
        methods: ['GET']
    )]
    public function getProducts(ProductRepository $productRepository, Request $request)
    {
        $param = $this->verifyParamRouter($request, ['store'    ]);
        $products = $productRepository->productsForStore($param['store']);
        $data = [];
        {
        foreach($products as $product)
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'storeId' => $product->getStore()->getId()
            ];
        }

        return new JsonResponse($data);
    }
}