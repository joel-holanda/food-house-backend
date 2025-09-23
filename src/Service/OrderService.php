<?php

namespace App\Service;

use _PHPStan_f2f2ddf44\Nette\Utils\DateTime;
use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Model\OrderModel;
use App\Model\OrderProductModel;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class OrderService
{
    private $productRepository;
    private $userRepository;
    private $em;
    public function __construct(UserRepository $userRepository, EntityManagerInterface $em, ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    public function createOrder(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        [
            'userId' => $userId,
            'description' => $description,
            'paymentMethod' => $paymentMethod,
            'products' => $products
        ] = $content;

        $user = $this->userRepository->findUserId($userId);
        
        $order = new Order();
        $order
            ->setUser($user)
            ->setDescription($description)
            ->setPaymentMethod($paymentMethod)
            ->setStatus(Order::STATUS_ORDER_PROGRESS)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $this->em->persist($order);

        foreach ($products as $item) {
            $product = $this->productRepository->find(['id' => $item['id']]);

            $orderProduct = new OrderProduct();
            $orderProduct
                ->setOrder($order)
                ->setProduct($product)
                ->setQuantity($item['quantity'])
                ->setCreatedAt(new \DateTimeImmutable())
                ->setUpdatedAt(new \DateTimeImmutable());

            $this->em->persist($orderProduct);
        }

        $this->em->flush();

        return $order;
    }

    public function modifyOrder(Request $request, Order $order)
    {
        $content = json_decode($request->getContent(), true);
        
        [
            'description' => $description,
            'paymentMethod' => $paymentMethod,
            'products' => $products
        ] = $content;
    }
}