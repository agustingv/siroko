<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Product;

class ProductTest extends ApiTestCase
{
    public function testCreateProduct(): void
    {
        static::createClient()->request('POST', '/products', [
            'json' => [
                'name' => 'Product 1',
                'price' => 1.0,
                'stock' => 10,
                'description' => 'description'
            ],
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/contexts/Product',
            '@type' => 'Product',
            'name' => 'Product 1',
            'price' => 1,
            'stock' => 10,
            'description' => 'description'
        ]);
    }

    public function testUpdateProduct(): void
    {
        $client = static::createClient();
        $product = $this->createProduct();
        $client->request('PATCH', '/products/'.$product->getId(), [
            'json' => [
                'name' => 'Product Update',
            ],
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'id' => $product->getId(),
            'name' => 'Product Update',
        ]);
    }

    public function testDeleteProduct(): void
    {

        $client = static::createClient();

        $product = $this->createProduct();

        $client->request('DELETE', '/products/'.$product->getId());

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Product::class)->findOneBy(['id' => $product->getId()])
        );
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
