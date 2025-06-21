<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use App\ValueObject\State;

#[ORM\Entity(repositoryClass: CartRepository::class)]
#[ApiResource]
class Cart
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class)]
    private Collection $product;

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
    public ?State $state
    {
        get { return $this->state; }
        set(?State $value) { $this->state = $value; }       
    }

    public function __construct()
    {
        $this->product = new ArrayCollection();
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
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->product->removeElement($product);
        return $this;
    }

}
