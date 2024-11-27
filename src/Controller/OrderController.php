<?php

namespace App\Controller;

use App\Entity\Order;
use App\Model\OrderModel;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends BaseController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route(
        '/orders',
        name: 'get_orders',
        methods: ['GET']
    )]
    public function index(OrderRepository $orderRepository, Request $request)
    {
        $param = $this->verifyParamRouter($request, ['userId']);
        if($param instanceof JsonResponse) return $param;

        $orders = $orderRepository->searchAllOrders($param['userId']);
        
        $data = [];
        foreach($orders as $order) {
            $data[] = new OrderModel($order);
        }
        
        $data = $this->serializer->serialize($data, 'json', ['groups' => ['order']]);
        print_r($data);exit;
        return new Response($data);
    }

    #[Route(
        '/order',
        name: 'create_order',
        methods: ['POST']
    )]
    public function createOrder(Request $request, EntityManagerInterface $em): Response
    {
        $param = $this->verifyParamRouter($request, ['userId', 'address', 'description']);
        if($param instanceof JsonResponse) return $param;

        $order = new Order;
        $order->setUser($param['userId']);
        $order->setStatus($param['address']);
        $order->setDescription($param['description']);
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
    public function updateOrder(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository, int $id): Response
    {
        $order = $orderRepository->find($id);

        if(!$order) return new Response('Pedido não encontandoo!!!!!');

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