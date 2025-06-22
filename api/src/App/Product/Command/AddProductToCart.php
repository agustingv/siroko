<?php

namespace App\App\Product\Command;


use App\Entity\Product;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Dto\Item;
use App\Repository\ProductRepository;

#[AsMessageHandler]
final class AddProductToCart
{

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(Item $item) : void
    {

        $product = $this->repository->findOneById((int)$item->id);
        var_dump($_COOKIE);
        var_dump($product->name);
       //return $item->id;
    }
}