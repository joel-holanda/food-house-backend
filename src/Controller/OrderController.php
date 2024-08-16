<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends AbstractController
{
    #[Route(
        '/order',
        name: 'number',
        methods: ['GET'],
    )]
    public function index(OrderRepository $orderRepository): JsonResponse
    {
        $orders = $orderRepository->findAll();

        $data = [];
        foreach ($orders as $order) {
            $data[] = [
                'id' => $order->getId(),
                'client_name' => $order->getClientName(),
                'client_address' => $order->getClientAddress(),
                'created_at' => $order->getCreatedAt(),
                'status' => $order->getStatus()
            ];
        }

        return new JsonResponse($data);
    }
}
