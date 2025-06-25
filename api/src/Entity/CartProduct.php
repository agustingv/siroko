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
    #[ORM\OneToOne(targetEntity: Product::class)]
    public Product $product
    {
        get { return $this->product; }
        set(?Product $value) { $this->product = $value; }       
    }

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

    public function getId(): ?int
    {
        return $this->id;
    }
}
