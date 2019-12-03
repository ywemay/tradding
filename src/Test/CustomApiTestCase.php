<?php

namespace App\Test;

use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use App\DataFixtures\ORM\LoadFixtures as LoadFixtures;

class CustomApiTestCase extends WebTestCase {

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
    }

    /**
     * Makes an request logged in with ROLE_USER.
     * @param string|array|null $content
     */
    public function request_as_user(string $method, string $uri, $content = null, array $headers = []) : Response {
        $headers += [
            'PHP_AUTH_USER' => 'user',
            'PHP_AUTH_PW'   => 'user',
        ];
        return $this->request($method, $uri, $content, $headers);
    }

    /**
     * Makes an request logged in with ROLE_MODERATOR.
     * @param string|array|null $content
     */
    public function request_as_moderator(string $method, string $uri, $content = null, array $headers = []) : Response {
        $headers += [
            'PHP_AUTH_USER' => 'moderator',
            'PHP_AUTH_PW'   => 'moderator',
        ];
        return $this->request($method, $uri, $content, $headers);
    }

    /**
     * Makes an request logged in with ROLE_ADMIN.
     * @param string|array|null $content
     */
    public function request_as_admin(string $method, string $uri, $content = null, array $headers = []) : Response {
        $headers += [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => 'admin',
        ];
        return $this->request($method, $uri, $content, $headers);
    }

    /**
     * @param string|array|null $content
     */
    protected function request(string $method, string $uri, $content = null, array $headers = []): Response
    {
        $server = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'content-type') {
                $server['CONTENT_TYPE'] = $value;

                continue;
            }

            $server['HTTP_'.strtoupper(str_replace('-', '_', $key))] = $value;
        }

        if (is_array($content) && false !== preg_match('#^application/(?:.+\+)?json$#', $server['CONTENT_TYPE'])) {
            $content = json_encode($content);
        }

        $this->client->request($method, $uri, [], [], $server, $content);

        return $this->client->getResponse();
    }

    protected function findOneIriBy(string $resourceClass, array $criteria): string
    {
        $resource = static::$container->get('doctrine')->getRepository($resourceClass)->findOneBy($criteria);

        return static::$container->get('api_platform.iri_converter')->getIriFromitem($resource);
    }
}
