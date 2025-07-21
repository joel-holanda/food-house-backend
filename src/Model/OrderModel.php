<?php

namespace App\Model;

use App\Entity\Order;
use App\Entity\User;

class OrderModel 
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $status;

    /**
     * @var string
     */
    public $payment_method;

    /**
     * @var string
     */
    public $description;

    /**
     * @var User
     */
    public $user;

    public function __construct(Order $order)
    {
        if($order) {
            $this->id = $order->getId();
            $this->status = $order->getStatus();
            $this->payment_method = $order->getPaymentMethod();
            $this->description = $order->getDescription();
            $this->user = $order->getUser();
        }
    }
}