<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class StoreModel
{
    #[Assert\NotBlank(message: "O campo name é obrigatorio")]
    public string $name;

    #[Assert\NotBlank(message: "O campo description é obrigatorio")]
    public string $description;

    #[Assert\NotBlank(message: "O campo email é obrigatorio")]
    #[Assert\Email(message: "fortamdo do email invalido")]
    public string $email;

    #[Assert\NotBlank(message: "O campo email é obrigatorio")]
    public int $cnpj;
}

// class StoreModel
// {
//     /**
//      * @var int
//      */
//     private $id;

//     /**
//      * @var string
//      */
//     public $name;

//     /**
//      * @var string
//      */
//     public $description = null;

//     /**
//      * @var int
//      */
//     public $cnpj;

//     /**
//      * @var string
//      */
//     public $email;

//     /**
//      * @var int
//      */
//     public $photo;

//     public function __construct(Store $store = null)
//     {
//         if($store){
//             $this->id = $store->getId();
//             $this->name = $store->getName();
//             $this->description = $store->getDescription();
//             $this->cnpj = $store->getCnpj();
//             $this->email = $store->getEmail();
//             $this->photo = $store->getPhoto();
//         }

//     }

// }