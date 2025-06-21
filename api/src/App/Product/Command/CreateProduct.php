<?php

namespace App\App\Product\Command;

use App\Entity\Product;

class CreateProduct
{
    public function __construct(
        public Product $content,
    ) {}

    public function getContent() : Product
    {
        return $this->content;
    }
}