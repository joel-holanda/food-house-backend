<?php

namespace App\Model;

use App\Entity\Product;

class ProductsModel
{
    private $id;
    public $name;

    public $price;

    public $description;

    public $photo;

    public $typeProduct;
    public function __construct(Product $products = null)
    {
        if($products) {
            $this->id = $products->getId();
            $this->name = $products->getName();
            $this->price = $products->getPrice();
            $this->description = $products->getDescription();
            $this->photo = $products->getPhoto();
            $this->typeProduct= [
                'name' => $products->getTypeProduct()->getName(),
                'description' => $products->getTypeProduct()->getDescription()
            ];
        }
    }
}