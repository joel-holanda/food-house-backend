<?php

namespace App\Model;

use App\Entity\Product;
use App\Entity\TypeProduct;

class ProductModel
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string 
     */
    private $name;
    /**
     *  @var float
     */
    private $price;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $photo;
    /**
     * @var \DateTime
     */
    private $created_at;
    /**
     * @var \DateTime
     */
    private $updated_at;
    /**
     * @var TypeProduct|null
     */
    private $typeProduct;

    public function __construct(Product $product)
    {
        $this->id = $product->getId();
        $this->name = $product->getName();
        $this->price = $product->getPrice();
        $this->description = $product->getDescription();
        $this->photo = $product->getPhoto();
        $this->created_at = $product->getCreatedAt();
        $this->updated_at = $product->getUpdatedAt();

        if($product->getTypeProduct()->getId()){
            $this->typeProduct = [
                "id" => $this->typeProduct = $product->getTypeProduct()->getId(),
                "name" => $this->typeProduct = $product->getTypeProduct()->getName(),
                "description" => $this->typeProduct = $product->getTypeProduct()->getDescription()
            ];
        }
    }
}