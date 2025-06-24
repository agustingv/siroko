<?php

namespace App\App\Product\Command;


use App\Entity\Product;
use App\Entity\Cart;
use App\Entity\CartProduct;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Dto\CartRemoveItem;
use App\Repository\ProductRepository;
use App\Repository\CartRepository;
use App\Repository\CartProductRepository;
use DateTime;

#[AsMessageHandler]
final class RemoveProductFromCart
{

    public function __construct(
        public ProductRepository $ProductRepository, 
        public CartRepository $CartRepository,
        public CartProductRepository $CartProductRepository)
    {

    }

    public function __invoke(CartRemoveItem $item) : Cart | null
    {
        
        $product = $this->ProductRepository->findOneById((int)$item->id);
  

        if ($cart = $this->CartRepository->findById($item->cart_id))
        {
            
            $cartProduct = $cart->getCartProducts();
            $cartProduct->removeProduct($product);
            $this->CartProductRepository->update($cartProduct, true);
            $products = $cartProduct->getProduct();
            if (count($products) === 0)
            {
               $this->CartRepository->delete($cart, true);
               return NULL;
            }
            return $cart;
        }

        return NULL;
    }
}