<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Product;

class addProductToCartTest extends ApiTestCase
{
    public function testAddProductCart(): void
    {
        $product = $this->createProduct();
        static::createClient()->request('POST', '/carts/product/add', [
            'json' => [
                'id' => $product->getId(),
                'quantity' => 1,
                'cart_id' => '29d473b6-ba97-4153-8e4b-9bb72b29d355'
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(202);
        $this->assertJsonContains([
            '@context' => '/contexts/Cart',
            '@type' => 'Cart',
        ]);
    }

    public function testRemoveProductCart(): void
    {
        $product = $this->createProduct();
        static::createClient()->request('POST', '/carts/product/remove', [
            'json' => [
                'id' => $product->getId(),
                'quantity' => 1,
                'cart_id' => '29d473b6-ba97-4153-8e4b-9bb72b29d355'
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(202);
    }
    private function createProduct() : ?Product
    {
        $product = new Product();
        $product->name = "Test Product";
        $product->price = 128.0;
        $product->stock = 30;
        $product->description = "description";
        return static::getContainer()->get('doctrine')->getRepository(Product::class)->create($product, true);

    }
}