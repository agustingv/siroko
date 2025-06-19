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
                'stock' => 10
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
            'stock' => 10
        ]);
    }

    public function testUpdateProduct(): void
    {
        $client = static::createClient();
        $iri = $this->findIriBy(Product::class, ['id' => '1']);
        $client->request('PATCH', $iri, [
            'json' => [
                'name' => 'Product Update',
            ],
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'id' => 1,
            'name' => 'Product Update',
        ]);
    }

    public function testDeleteProduct(): void
    {

        $client = static::createClient();
        $iri = $this->findIriBy(Product::class, ['id' => '1']);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Product::class)->findOneBy(['id' => '1'])
        );
    }

}
