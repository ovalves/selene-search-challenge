<?php

use PHPUnit\Framework\TestCase;

class GetUserByNameTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost:8000/users/name']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function testGetUsersByName()
    {
        $response = $this->http->request('GET');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()['Content-Type'][0];
        $this->assertEquals('application/json', $contentType);
    }
}
