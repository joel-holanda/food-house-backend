<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class StoreModel
{
    #[Assert\NotBlank(message: "The field name is not find")]
    public string $name;

    #[Assert\NotBlank(message: "The field description is not find")]
    public string $description;

    #[Assert\NotBlank(message: "The field email is not find")]
    #[Assert\Email(message: "fortamdo do email invalido")]
    public string $email;

    #[Assert\NotBlank(message: "field cnpj is not find")]
    public int $cnpj;
}