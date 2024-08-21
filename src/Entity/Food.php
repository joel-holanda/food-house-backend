<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $flavors = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ManyToOne(targetEntity: Store::class)]
    #[JoinColumn(name: 'store_id', referencedColumnName: 'id')]
    private Store|null $store = null;

    #[ORM\ManyToMany(targetEntity: OrderFood::class, mappedBy: 'order_id')]
    private Collection $orderFood;

    public function __construct()
    {
        $this->orderFood = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFlavors(): ?string
    {
        return $this->flavors;
    }

    public function setFlavors(string $flavors): static
    {
        $this->flavors = $flavors;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getStoreId(): Store
    {
        return $this->store;
    }

    /**
     * @return Collection<int, OrderFood>
     */
    public function getOrderFood(): Collection
    {
        return $this->orderFood;
    }

    public function addOrderFood(OrderFood $orderFood): static
    {
        if (!$this->orderFood->contains($orderFood)) {
            $this->orderFood->add($orderFood);
            $orderFood->addOrderId($this);
        }

        return $this;
    }

    public function removeOrderFood(OrderFood $orderFood): static
    {
        if ($this->orderFood->removeElement($orderFood)) {
            $orderFood->removeOrderId($this);
        }

        return $this;
    }
}
