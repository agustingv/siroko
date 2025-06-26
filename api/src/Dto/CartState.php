<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;


final class CartState
{
        public string $state;
        public string $cart_id;
}