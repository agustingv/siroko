<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;


final class CartItem
{
        public int $id;
        public int $quantity;
        public string $cart_id;
}