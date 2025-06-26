<?php

namespace App\Entity;

use App\Repository\CartProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartProductRepository::class)]
#[ApiResource]
class CartProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class)]
    public Collection $products;

    #[ORM\Column]
    public ?int $quantity
    {
        get { return $this->quantity; }
        set(?int $value) { $this->quantity = $value; }       
    }

    #[ORM\Column]
    public ?string $session_id
    {
        get { return $this->session_id; }
        set(?string $value) { $this->session_id = $value; }       
    }

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducts(): Collection | null
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product))
        {
            $this->products->add($product);
        }
        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->products->removeElement($product);

        return $this;
    }

}
