<?php

namespace App\Model;

class OrderProductModel
{
    public $id;
    public $quantity;

    public function __construct($product = null, int $quantity = 0)
    {
        if ($product) {
            $this->id = $product->getId();
            $this->quantity = $quantity;
        }
    }
}