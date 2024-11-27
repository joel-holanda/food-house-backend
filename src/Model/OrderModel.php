<?php

namespace App\Model;

use App\Entity\Order;
use App\Entity\OrderProduct;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderModel
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $payment_method;

    /**
     * @var string
     */
    private $description;

    /**
     * @var User
     */
    private $user;

    /**
     * @var OrderProduct
     */
    private $orderProduct;

    /**
     * @var \DateTime
     */
    private $created_at;

    /**
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @param Order|null $order
     */
    public function __construct(Order $order = null)
    {
        if($order) {
            $this->id = $order->getId();
            $this->status = $order->getStatus();
            $this->payment_method = $order->getPaymentMethod();
            $this->description = $order->getDescription();
            $this->created_at = $order->getCreatedAt();  
            $this->updated_at = $order->getUpdatedAt();  
            if($order->getUser()) {
                $this->user = [
                    "id" => $order->getUser()->getId(),
                    "name" => $order->getUser()->getName()
                ];
            }
        }
        else {
            return new JsonResponse("Usuario não encontrado", 201);
        }
    }

}
