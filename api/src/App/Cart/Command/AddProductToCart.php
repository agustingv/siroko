<?php

namespace App\App\Cart\Command;


use App\Entity\Product;
use App\Entity\Cart;
use App\Entity\CartProduct;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Dto\CartItem;
use App\Repository\ProductRepository;
use App\Repository\CartRepository;
use App\Repository\CartProductRepository;
use DateTime;

#[AsMessageHandler]
final class AddProductToCart
{

    public function __construct(
        public ProductRepository $ProductRepository, 
        public CartRepository $CartRepository,
        public CartProductRepository $CartProductRepository)
    {

    }

    public function __invoke(CartItem $item) : Cart | null
    {
        if ($product = $this->ProductRepository->findOneById((int)$item->id))
        {
  

            if ($cart = $this->CartRepository->findById($item->cart_id))
            {
                if ($cartProduct = $this->CartProductRepository->findByProduct($product, $cart->session_id))
                {
                    $cartProduct->quantity = $cartProduct->quantity+1;
                    $this->CartProductRepository->update($cartProduct, true);
                }
                else 
                {
                    $cartProduct = new CartProduct();
                    $cartProduct->addProduct($product);
                    $cartProduct->session_id = $cart->session_id;
                    $cartProduct->quantity = (int)$item->quantity;
                    $this->CartProductRepository->create($cartProduct, true);
                    $cart->addCartProduct($cartProduct);
                    $this->CartRepository->update($cart);
                }
                return $cart;
            }
            else
            {
                $cart = new Cart();
                $cart->session_id = $item->cart_id;
                $cart->customer_id = 0;
                $cart->total_price = 0;
                $cart->created_at = new DateTime('now');
                $cart->updated_at = new DateTime('now');
                $cart->state = 'init';
                $this->CartRepository->create($cart);

                $cartProduct = new CartProduct();
                $cartProduct->addProduct($product);
                $cartProduct->quantity = (int)$item->quantity;
                $cartProduct->session_id = $cart->session_id;

                $this->CartProductRepository->create($cartProduct, true);

                $cart->addCartProduct($cartProduct);

                $this->CartRepository->update($cart);
                return $cart;

            }
    }

        
        return NULL;
    }
}