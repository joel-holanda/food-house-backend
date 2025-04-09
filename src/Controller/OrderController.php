<?php

namespace App\Controller;

use App\Entity\Order;
use App\Model\OrderModel;
use App\Form\Type\OrderType;
use App\Repository\OrderRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends BaseController
{
    #[Route(
        '/orders',
        name: 'get_orders',
        methods: ['GET'],
    )]
    public function index(OrderRepository $orderRepository, Request $request): JsonResponse
    {

        $param = ['userId'];
        $this->verifyParamRouter($request, $param);

        $orders = $orderRepository->searchAllOrders($param['userId']);

        if($orders == []) return new JsonResponse("Usuario não encontrado", 201);

        $data = [];
        foreach ($orders as $order) {
            $data[] = [
                'id' => $order->getId(),
                'client_name' => $order->getUser()->getName(),
                'status' => $order->getStatus(),
                'paymentMethod' => $order->getPaymentMethod(),
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
    public function createOrder(Request $request, UserRepository $userRepository)
    {
        $order = new Order;
        $form = $this->createForm(OrderType::class, $order);
        $this->verifyForm($form, $request);

        $data = json_decode($request->getContent(), true);

        $users = $userRepository->findUserId($data['userId']);
        $userId = '';
        foreach($users as $user) {
                $userId = $user;
            }
            $order->setUser($userId);
            $order->setCreatedAt(new \DateTimeImmutable('now'));
            $order->setUpdatedAt(new \DateTimeImmutable('now'));
            $order->setPaymentMethod($data['paymentMethod']);
            $order->setDescription($data['description']);
            $order->setStatus(Order::STATUS_ORDER_PROGRESS);
            
        return $this->responseApi(new OrderModel($order), Response::HTTP_CREATED);
        // return new Response('Order create with sucess! ' . $order->getId());
    }

    #[Route(
        '/order/{id}/update',
        name: 'update_order',
        methods: ['PUT']
    )]
    public function updateOrder(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository, int $id, UserRepository $userRepository): Response
    {
        $order = $orderRepository->find($id);

        if(!$order) {
            return new Response('Pedido não encontandoo!!!!!');
        }

        $data = json_decode($request->getContent(), true);
        $users = $userRepository->findUserId($data['userId']);
        $userId = '';
        foreach($users as $user) {
            $userId = $user;
        }

        
        if($data['userId']) {
            $order->setUser($userId);
        }
        if($data['payment']) {
            $order->setPaymentMethod($data['payment']);
        }
        if($data['description']) {
            $order->setDescription($data['description']);
        }
        $order->setUpdatedAt(new \DateTimeImmutable('now'));
        $em->persist($order);
        $em->flush();

        return new Response('Pedido atualizado com sucesso hehe!!', 200);
    }
}