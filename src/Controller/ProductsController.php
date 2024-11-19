<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends BaseController
{
    #[Route(
        '/products',
        name: 'get_products',
        methods: ['GET']
    )]
    public function getProducts(ProductRepository $productRepository, Request $request)
    {
        $param = $this->verifyParamRouter($request, ['store']);
        if($param instanceof Response) return $param;
        
        $products = $productRepository->productsForStore($param['store']);
        $data = [];
        
        foreach($products as $product)
        {
            $data[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'typeId' => $product->getTypeProduct()->getId(),
                'storeId' => $product->getStore()->getId()
            ];
        }

        return new JsonResponse($data);
    }
}