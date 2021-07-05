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
     * Undocumented function
     *
     * @return void
     */
    public function testGetUsersByName()
    {
        $users = $this->gateway->findUsersByUserName(
            'Edmundo',
            1,
            10
        );

        echo '<pre>';
        var_dump ($users);
        die();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
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

    /**
     * Cria e o container de gateway de usuários
     * Utilizado para testar as querys de usuários
     *
     * @return void
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
