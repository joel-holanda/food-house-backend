<?php

namespace App\Controller;

use App\Form\Type\OrderType;
use App\Model\OrderModel;
use App\Service\OrderService;
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
    public function index(OrderRepository $orderRepository, Request $request)
    {

        $userId = $request->query->get('userId');
        $orders = $orderRepository->searchAllOrders($userId);
        $orderModel = [];
        /** @var \App\Entity\Order $order*/
        foreach ($orders as $order) {
            $orderModel[] = new OrderModel($order);
        }

        $data = $this->normalizer->normalize($orderModel, 'json');

        return new JsonResponse(["data" => $data]);
    }

    #[Route(
        '/order',
        name: 'create_order',
        methods: ['POST']
    )]
    public function addOrder(Request $request, OrderService $orderService)
    {
        $form = $this->createForm(OrderType::class, new OrderModel());
        $errors = $this->verifyForm($form, $request);
        if($errors) return $errors;

        $order = $orderService->createOrder($request);
        $data = $this->serializer->serialize(new OrderModel($order), 'json');

        return new Response($data);
    }

    #[Route(
        '/order/{id}/update',
        name: 'update_order',
        methods: ['PUT']
    )]
    public function updateOrder(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository, int $id, UserRepository $userRepository): Response
    { 
        $order = $orderRepository->find($id);

        if (!$order) {
            return new Response('Pedido não encontandoo!!!!!');
        }

        

        return new Response('Pedido atualizado com sucesso hehe!!', 200);
    }

    #[Route(
        'order/{id}/remove',
        name: 'remove_order',
        methods: ['DELETE']
    )]
    public function deleteOrder(Request $request, EntityManagerInterface $em, OrderRepository $orderRepository, int $id)
    {
        $order = $orderRepository->find($id);

        if (!$order) {
            return new Response('Pedido não encontandoo!!!!!');
        }

        $em->remove($order);
        $em->flush();

        return new Response('apagado com sucesso!!');
    }
}
