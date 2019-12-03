<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JWTokenControllerTest extends WebTestCase
{
    public function testPOSTCreateToken()
    {
        //$this->createUser('weaverryan', 'I<3Pizza');
        $response = $this->client->post('/api/tokens', [
            'auth' => ['admin', 'admin']
        ]);
        $this->assertEquals(200, $response->getStatusCode());
        $this->asserter()->assertResponsePropertyExists(
            $response,
            'token'
        );
    }
}
