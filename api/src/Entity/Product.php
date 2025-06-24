<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use App\Dto\Item;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(operations: [
  new GetCollection(),
  new Post(),
  new Post(
      name: 'add_item_cart',
      status: 202,
      messenger: 'input',
      input: Item::class,
      output: false,
      uriTemplate: '/product/{id}/{quantity}/add'
  ),
  new Delete(),
  new Patch()
])]

class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name
    {
        get { return $this->name; }
        set(?string $value) { $this->name = $value; }       
    }

    #[ORM\Column]
    public ?float $price
    {
        get { return $this->price; }
        set(?float $value) { $this->price = $value; }       
    }

    #[ORM\Column]
    public ?int $stock
    {
        get { return $this->stock; }
        set(?int $value) { $this->stock = $value; }       
    }

    #[ORM\Column]
    public ?string $description
    {
        get { return $this->description; }
        set(?string $value) { $this->description = $value; }       
    }

    /**
     * @var Collection<int, CartProduct>
     */
    #[ORM\ManyToMany(targetEntity: CartProduct::class, mappedBy: 'product')]
    private Collection $cartProducts;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, CartProduct>
     */
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }

    public function addCartProduct(CartProduct $cartProduct): static
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            $this->cartProducts->add($cartProduct);
            $cartProduct->addProduct($this);
        }

        return $this;
    }

    public function removeCartProduct(CartProduct $cartProduct): static
    {
        if ($this->cartProducts->removeElement($cartProduct)) {
            $cartProduct->removeProduct($this);
        }

        return $this;
    }

}
