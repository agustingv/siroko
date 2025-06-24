<?php

namespace App\App\Product\Command;


use App\Entity\Product;
use App\Entity\Cart;
use App\Entity\CartProduct;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Dto\CartItem;
use App\Repository\ProductRepository;
use App\Repository\CartRepository;
use App\Repository\CartProductRepository;
use DateTime;
use App\ValueObject\CartState;

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
        
        $product = $this->ProductRepository->findOneById((int)$item->id);
  

        if ($cart = $this->CartRepository->findById($item->cart_id))
        {
            
            $cartProduct = $cart->getCartProducts();
            $cartProduct->addProduct($product);
            $this->CartProductRepository->update($cartProduct, true);
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
            $this->CartRepository->create($cart, true);

            $cartProduct = new CartProduct();
            $cartProduct->quantity = $item->quantity;
            $cartProduct->addCart($cart);
            $cartProduct->addProduct($product);

            $this->CartProductRepository->create($cartProduct, true);
            return $cart;

        }

        
        return NULL;
    }
}