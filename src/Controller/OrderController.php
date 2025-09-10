<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\Type\OrderType;
use App\Model\OrderModel;
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

        $storeId = $request->query->get('storeId');
        $orders = $orderRepository->searchAllOrders($storeId);

        $orderModel = [];
        foreach ($orders as $order) {
            $orderModel[] = new OrderModel($order);
        }

        $data = $this->normalizer->normalize($orderModel, 'json');

        return new JsonResponse($data);
    }

    #[Route(
        '/order',
        name: 'create_order',
        methods: ['POST']
    )]
    public function createOrder(Request $request, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $form = $this->createForm(OrderType::class, new OrderModel());

        $errors = $this->verifyForm($form, $request);
        if($errors) return $errors;

        $order = new Order();

        $this->serializer->deserialize($request->getContent(), Order::class, 'json', context: ['object_to_populate' => $order]);

        $em->persist($order);
        $em->flush();

        $data = $this->serializer->serialize($order, 'json');

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

        $data = json_decode($request->getContent(), true);

        if (array_key_exists('userId', $data)) {
            $users = $userRepository->findUserId($data['userId']);
            $userId = '';
            foreach ($users as $user) {
                $userId = $user;
            }
            $order->setUser($userId);
        }
        if (array_key_exists('payment', $data)) {
            $order->setPaymentMethod($data['payment']);
        }
        if (array_key_exists('description', $data)) {
            $order->setDescription($data['description']);
        }
        $order->setUpdatedAt(new \DateTimeImmutable('now'));
        $em->persist($order);
        $em->flush();

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
