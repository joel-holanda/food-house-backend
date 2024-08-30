<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\Type\OrderType;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends AbstractController
{
    #[Route(
        '/orders',
        name: 'get_orders',
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
        $order->setClientName($data['name']);
        $order->setClientAddress($data['address']);
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
    public function updateOrder(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository, $id): Response
    {
        $order = $orderRepository->find($id);

        if(!$order) {
            return new Response('Pedido não encontandoo!!!!!');
        }

        $data = json_decode($request->getContent(), true);
        
        if($data["name"]) {
            $order->setClientName($data["name"]);
        }
        if($data["address"]) {
            $order->setClientAddress($data["address"]);
        }

        $em->persist($order);
        $em->flush();

        return new Response('Pedido atualizado com sucesso hehe!!', 200);
    }
}