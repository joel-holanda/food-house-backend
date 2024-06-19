<?php

namespace App\Entity;

use App\Repository\TesteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TesteRepository::class)]
class Teste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $campoA = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampoA(): ?string
    {
        return $this->campoA;
    }

    public function setCampoA(?string $campoA): static
    {
        $this->campoA = $campoA;

        return $this;
    }
}
