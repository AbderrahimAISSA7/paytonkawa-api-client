<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiUserTest extends WebTestCase
{
    public function testGetUsers()
    {
        $client = static::createClient();

        $client->request('GET', '/api/users');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreateUser()
    {
        $client = static::createClient();

        $client->request('POST', '/api/users', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'username' => 'john_doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123'
        ]));

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    // Ajoutez d'autres tests pour les autres endpoints
}
