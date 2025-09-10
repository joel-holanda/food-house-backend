<?php

namespace App\Model;

use App\Entity\Order;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class OrderModel 
{
    public $status = ORder::STATUS_ORDER_PROGRESS;

    #[Assert\NotBlank(message: "The field status is not find")]
    public $paymentMethod;

    #[Assert\NotBlank(message: "The field description is not find")]
    public $description;

    #[Assert\NotBlank(message: "The field user is not find")]
    public $userId;

    public function __construct(Order $order = null)
    {
        if($order) {
            $this->id = $order->getId();
            $this->status = $order->getStatus();
            $this->paymentMethod = $order->getPaymentMethod();
            $this->description = $order->getDescription();
            $this->user = $order->getUser()->getName();
        }
    }
}