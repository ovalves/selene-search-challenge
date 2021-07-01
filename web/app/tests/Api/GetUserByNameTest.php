<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class GetUserByNameTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new Client(['base_uri' => 'http://localhost:8000']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function testGetUsersByName()
    {
        $this->setName('Test: Busca usuários por nome');
        $response = $this->http->request('GET', '/users/name');
        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()['Content-Type'][0];
        $this->assertEquals('application/json', $contentType);
    }

    public function testSearchExistentUserByName()
    {
        $this->setName('Test: Buscando um usuário por nome existente na base de dados');
        $response = $this->http->request('GET', '/users/name', [
            'query' => ['query' => 'Edmundo'],
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()['Content-Type'][0];
        $this->assertEquals('application/json', $contentType);
    }
}
