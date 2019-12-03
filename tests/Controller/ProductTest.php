<?php

namespace App\Test\Controller;

use App\Test\CustomApiTestCase;
use App\Entity\Product;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;
use App\DataFixtures\ORM\LoadFixtures;

class ProductTest extends CustomApiTestCase
{

    /**
     * Retrieves product list.
     */
    public function testProductList():void
    {
        $response = $this->request_as_user('GET', 'api/products');

        $content = $response->getContent();

        $json = json_decode($content, true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('hydra:totalItems', $json);
        $this->assertEquals(25, $json['hydra:totalItems']);

        $this->assertArrayHasKey('hydra:member', $json);
        $this->assertCount(25, $json['hydra:member']);
    }

    /**
     * Throw errors when data are invalid.
     */
    public function testThrowErrorsWhenDataAreInvalid(): void {
        $data = array(
            'name' => '',
        );
        $response = $this->request_as_moderator('POST', 'api/products', $data);
        $content = $response->getContent();

        $json = json_decode($content, true);

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('violations', $json);
        $this->assertCount(1, $json['violations']);

        $this->assertArrayHasKey('propertyPath', $json['violations'][0]);
        $this->assertEquals('name', $json['violations'][0]['propertyPath']);
    }

    /**
     * Tests create a product.
     */
    public function testCreateAProduct(): void
    {
        $data = [
            'name' => 'Sample Product Name',
        ];

        $response = $this->request_as_moderator('POST', '/api/products', $data);
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('name', $json);
        $this->assertEquals($data['name'], $json['name']);
    }

    /**
     * Tests product update.
     */
    public function testUpdateAProduct(): void
    {
        $data = [
            'name' => 'Sample Product Updated',
        ];

        $response = $this->request_as_moderator('PUT', $this->findOneIriBy(Product::class, []), $data);
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/ld+json; charset=utf-8', $response->headers->get('Content-Type'));

        $this->assertArrayHasKey('name', $json);
        $this->assertEquals($data['name'], $json['name']);
    }

     /**
     * Deletes a product.
     */
    public function testDeleteAProduct(): void
    {
        $response = $this->request_as_admin('DELETE', $this->findOneIriBy(Product::class, []));
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    /**
     * Retrieves the documentation.
     */
    public function testRetrieveTheDocumentation(): void
    {
        $response = $this->request('GET', '/api', null, ['Accept' => 'text/html']);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('text/html; charset=UTF-8', $response->headers->get('Content-Type'));

        $this->assertStringContainsString('swagger-data', $response->getContent());
    }

}
