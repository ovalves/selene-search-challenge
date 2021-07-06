<?php

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class GetUserByNameTest extends TestCase
{
    private $http;
    private $gateway;

    public function setUp(): void
    {
        $this->initGateway();
        $this->http = new Client(['base_uri' => 'http://localhost:8000']);
    }

    public function tearDown(): void
    {
        $this->http = null;
        $this->gateway = null;
    }

    /**
     * Test: Executando a query de busca de usuários por nome.
     */
    public function testGetUsersByName(): void
    {
        $this->setName('Test: Executando a query de busca de usuários por nome.');
        $users = $this->gateway->findUsersByName(
            'Edmundo',
            1,
            10
        );

        $this->assertEquals(3, count($users));
    }

    /**
     * Test: Executando a query de busca de usuários por nome de usuário.
     */
    public function testSearchExistentUserByName(): void
    {
        $this->setName('Test: Executando a query de busca de usuários por nome de usuário.');
        $users = $this->gateway->findUsersByUserName(
            'Edmundo',
            1,
            10
        );

        $this->assertEquals(3, count($users));
    }

    /**
     * Cria e o container de gateway de base de dados para a tabela users.
     */
    private function initGateway(): void
    {
        $app = \Selene\App\Factory::create('/var/www/html/app/');

        $containers = $app->container();
        $containers->setPrefix('UsersGateway')->set(
            \UsersGateway::class
        );

        $this->gateway = $containers->get('UsersGateway');
    }
}
