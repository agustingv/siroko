<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use App\Dto\CartItem;
use App\Dto\CartRemoveItem;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;

#[ORM\Entity(repositoryClass: CartRepository::class)]
#[ApiResource(operations: [
  new GetCollection(),
  new Post(),
  new Post(
      name: 'add_item_cart',
      status: 202,
      messenger: 'input',
      input: CartItem::class,
      uriTemplate: '/carts/product/add'
  ),
new Post(
      name: 'remove_item_cart',
      status: 202,
      messenger: 'input',
      input: CartRemoveItem::class,
      uriTemplate: '/carts/product/remove'
  ),
  new Delete(),
  new Patch()
])]
class Cart
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Assoc cart to user session id
     */
    #[ORM\Column]
    public ?string $session_id
    {
        get { return $this->session_id; }
        set(?string $value) { $this->session_id = $value; }
    }

    #[ORM\Column]
    public ?string $customer_id
    {
        get { return $this->customer_id; }
        set(?string $value) { $this->customer_id = $value; }
    }
    
    #[ORM\Column]
    public ?float $total_price
    {
        get { return $this->total_price; }
        set(?float $value) { $this->total_price = $value; }
    }

    #[ORM\Column(type: 'datetime')]
    public DateTime $created_at
    {
        get { return $this->created_at; }
        set(DateTime $value) { $this->created_at = $value; }
    }

    #[ORM\Column(type: 'datetime')]
    public DateTime $updated_at 
    {
        get { return $this->updated_at; }
        set(DateTime $value) { $this->updated_at = $value; }
    }

    #[ORM\Column]
    public ?string $state
    {
        get { return $this->state; }
        set(?string $value) { $this->state = $value; }       
    }

    /**
     * @var Collection<int, CartProduct>
     */
    #[ORM\ManyToMany(targetEntity: CartProduct::class, inversedBy: 'cart', cascade: ["persist", "remove"])]
    private Collection|null $cartProducts;

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

    public function getCartProducts(): Collection | null
    {
        return $this->cartProducts;
    }

    public function addCartProduct(CartProduct $cartProduct): static
    {
        if (!$this->cartProducts->contains($cartProduct))
        {
            $this->cartProducts->add($cartProduct);
        }
        return $this;
    }

    public function removeCartProduct(CartProduct $cartProduct): static
    {
        $this->cartProducts->removeElement($cartProduct);

        return $this;
    }

}
