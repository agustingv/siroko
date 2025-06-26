<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

}
