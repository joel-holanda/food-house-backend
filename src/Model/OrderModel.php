<?php

namespace App\Model;

use App\Entity\Order;
use App\Model\OrderProductModel;
use Symfony\Component\Validator\Constraints as Assert;

class OrderModel 
{
    public $status;

    #[Assert\NotBlank(message: "The field paymentMethod is not find")]
    public $paymentMethod;

    #[Assert\NotBlank(message: "The field description is not find")]
    public $description;

    #[Assert\NotBlank(message: "The field user is not find")]
    public $userId;
    
    #[Assert\NotBlank(message: "The field products is not find")]
    /** @var OrderProductModel[] */
    public array $products = [];

    public function __construct(Order $order = null)
    {
        if($order) {
            $this->paymentMethod = $order->getPaymentMethod();
            $this->status = Order::STATUS_ORDER_PROGRESS;
            $this->description = $order->getDescription();
            $this->user = $order->getUser();
            foreach($order->getOrderProducts() as $item) {
                $this->products[] = new OrderProductModel($item->getProduct(), $item->getQuantity());
            }
        }
    }
}