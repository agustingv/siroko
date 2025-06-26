<?php

namespace App\App\Cart\Command;

use App\Entity\Cart;
use App\Entity\PaymentOrder;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Dto\CartState;
use App\Repository\CartRepository;
use App\Repository\PaymentOrderRepository;
use DateTimeImmutable;

#[AsMessageHandler]
final class UpdateCartState
{

    public function __construct(
        public CartRepository $CartRepository, 
        public PaymentOrderRepository $PORepository)
    {
    }

    public function __invoke(CartState $item) : Cart | null
    {
          
        if ($cart = $this->CartRepository->findById($item->cart_id))
        {
            $cart->state = $item->state;
            $this->CartRepository->update($cart, true);

            $po = new PaymentOrder();
            $po->addCart($cart);
            $po->setSessionId($cart->session_id);
            $po->setPrice($cart->getTotalPrice()); 
            $po->setCreateAt(new DateTimeImmutable('now'));

            $this->PORepository->create($po, true);

            return $cart;
        }

        return NULL;
    }
}