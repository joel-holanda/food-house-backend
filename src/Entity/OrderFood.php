<?php

namespace App\Entity;

use App\Repository\OrderFoodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderFoodRepository::class)]
class OrderFood
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Food::class, inversedBy: 'orderFood')]
    private Collection $order_id;

    public function __construct()
    {
        $this->order_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Food>
     */
    public function getOrderId(): Collection
    {
        return $this->order_id;
    }

    public function addOrderId(Food $orderId): static
    {
        if (!$this->order_id->contains($orderId)) {
            $this->order_id->add($orderId);
        }

        return $this;
    }

    public function removeOrderId(Food $orderId): static
    {
        $this->order_id->removeElement($orderId);

        return $this;
    }
}
