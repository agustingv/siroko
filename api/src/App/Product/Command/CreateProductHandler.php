<?php

namespace App\App\Product\Command;

use App\App\Product\Command\CreateProduct;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateProductHandler
{

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateProduct $content) : ?Product
    {
        try {
            $product = $content->getContent();
            return $this->repository->create($product, true);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}