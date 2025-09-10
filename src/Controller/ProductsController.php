<?php

namespace App\Controller;

use App\Entity\Product;
use App\Model\ProductsModel;
use App\Repository\ProductRepository;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductsController extends BaseController
{
    #[Route(
        '/products',
        name: 'get_products',
        methods: ['GET']
    )]
    public function getProducts(ProductRepository $productRepository, Request $request)
    {
        $storeId = $request->query->get('storeId');

        /** @var Product $products */
        $products = $productRepository->productsForStore($storeId);

        $productsModel = [];
        foreach ($products as $product) {
            $productsModel[] = new ProductsModel($product);
        }
        $data = $this->normalizer->normalize($productsModel, 'json');

        return new JsonResponse($data);
    }
}