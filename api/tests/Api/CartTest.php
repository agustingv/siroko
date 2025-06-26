<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Cart;
use App\Entity\Product;
use DateTime;

class CartTest extends ApiTestCase
{
    public function testCreateCart(): void
    {
        static::createClient()->request('POST', '/carts', [
            'json' => [
                'session_id' => '29d473b6-ba97-4153-8e4b-9bb72b29d3c0',
                'customer_id' => "customer",
                'created_at'  => "1/1/2025",
                'updated_at' => "1/1/2025",
                'state' => 'init'
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Cart',
            '@type' => 'Cart',
            'session_id' => '29d473b6-ba97-4153-8e4b-9bb72b29d3c0',
            'customer_id' => "customer",
            'created_at'  => "2025-01-01T00:00:00+00:00",
            'updated_at' => "2025-01-01T00:00:00+00:00",
            'state' => 'init'
        ]);
    }

    public function testDeleteCart(): void
    {

        $client = static::createClient();
        $cart = $this->createCart();
        $client->request('DELETE', '/carts/'.$cart->getId());

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Cart::class)->findOneBy(['id' => $cart->getId()])
        );
    }

    public function createCart(): ?Cart
    {
        $cart = new Cart();
        $cart->session_id = '29d473b6-ba97-4153-8e4b-9bb72b29d3c0';
        $cart->customer_id = 'customer';
        $cart->created_at = new DateTime('now');
        $cart->updated_at = new DateTime('now');
        $cart->state = 'init';
        return static::getContainer()->get('doctrine')->getRepository(Cart::class)->create($cart, true);
    }

}
