<?php

namespace App\Test;

use App\Test\CustomApiTestCase;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\DataFixtures\ORM\LoadFixtures;

class CustomApiUserTestCase extends CustomApiTestCase {

    // Enable alice database cleanup
    use RefreshDatabaseTrait;

    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $container = $this->client->getContainer();
        $doctrine = $container->get('doctrine');
        $entityManager = $doctrine->getManager();
        $fixture = new LoadFixtures();
        $fixture->load($entityManager);

        $this->client = static::createClient([],[
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'user',
        ]);

    }
}
