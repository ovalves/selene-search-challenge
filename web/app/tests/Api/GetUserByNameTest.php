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
     * Test: Ordem de retorno dos dados da API.
     */
    public function testGetUsersByNameOrder(): void
    {
        $this->setName('Test: Ordem de retorno dos dados da API');
        $users = $this->gateway->findUsersByName(
            'Edm',
            0,
            5
        );

        $expected = [
            0 => [
                'id'       => "e143a3c3-e4fc-4e13-85c6-21c3493b3bbd",
                'name'     => "Edmarine Rafaella",
                'username' => "edmarine.rafaella",
            ],
            1 => [
                'id'       => "067d1f2c-6ffc-452e-b250-49ce245c93ec",
                'name'     => "Edmy Rebeka",
                'username' => "edmy.rebeka",
            ],
            2	=> [
                'id'       => "12b7cb6a-a3c3-46ff-9011-487a26256818",
                'name'     => "Edmy Tosin",
                'username' => "edmytosin",
            ],
            3	=> [
                'id'       => "14088131-c1dd-4138-8fe6-697ba461503c",
                'name'     => "Edmarlow Dezan Erdei",
                'username' => "edmarlow.dezan.erdei",
            ],
            4	=> [
                'id'	    => "1624e388-fd37-473f-9f94-290e4908aa03",
                'name'	    => "Edmar Wagner",
                'username'	=> "edmar.wagner",
            ],
        ];

        $this->assertEquals($expected, $users);
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
