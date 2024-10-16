<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    #[Route(
        '/orders',
        name: 'get_orders',
        methods: ['GET'],
    )]
    public function index(OrderRepository $orderRepository, Request $request): JsonResponse
    {
        $context = json_decode($request->getContent(), true);

        $orders = $orderRepository->searchAllOrders($context['userId']);
        $data = [];
        foreach ($orders as $order) {
            $data[] = [
                'id' => $order->getId(),
                'client_name' => $order->getUser(),
                'status' => $order->getStatus(),
                'client_address' => $order->getPaymentMethod(),
                'created_at' => $order->getCreatedAt(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(
        '/order',
        name: 'create_order',
        methods: ['POST']
    )]
    public function createOrder(Request $request, EntityManagerInterface $em): Response
    {
        $context = $request->getContent();
        $data = json_decode($context, true);
        $order = new Order;
        $order->setUser($data['name']);
        $order->setStatus($data['address']);
        $order->setCreatedAt(new \DateTimeImmutable('now'));
        $order->setStatus(Order::STATUS_ORDER_PROGRESS);

        $em->persist($order);
        $em->flush();

        return new Response('Order create with sucess! ' . $order->getId());
    }

    #[Route(
        '/order/update/{id}',
        name: 'update_order',
        methods: ['PUT']
    )]
    public function updateOrder(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository,$id): Response
    {
        $order = $orderRepository->find($id);

        if(!$order) {
            return new Response('Pedido não encontandoo!!!!!');
        }

        $data = json_decode($request->getContent(), true);
        
        if($data['name']) {
            $order->setUser($data['name']);
        }
        if($data['address']) {
            $order->setUser($data['address']);
        }

        $em->persist($order);
        $em->flush();

        return new Response('Pedido atualizado com sucesso hehe!!', 200);
    }
}