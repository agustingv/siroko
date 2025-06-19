<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Cart;
use App\Entity\Product;

class CartTest extends ApiTestCase
{
    public function testCreateCart(): void
    {
        static::createClient()->request('POST', '/carts', [
            'json' => [
                'product' => [],
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Cart',
            '@type' => 'Cart',
            'id' => 1,
            'product' => []
        ]);
    }

    public function testDeleteCart(): void
    {

        $client = static::createClient();
        $iri = $this->findIriBy(Cart::class, ['id' => '1']);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Cart::class)->findOneBy(['id' => '1'])
        );
    }

}
