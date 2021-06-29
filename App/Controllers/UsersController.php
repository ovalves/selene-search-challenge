<?php
/**
 * @copyright   2019 - Selene
 * @author      Vinicius Oliveira <vinicius_o.a@live.com>
 * @category    Micro Framework
 * @since       2019-10-12
 */

use Selene\Controllers\BaseController;
use Selene\Request\Request;
use Selene\Response\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class UsersController extends BaseController
{
    private mixed $gateway = null;
    private string $name;
    private int $from;
    private int $size;

    public function getUserByName(Request $request, Response $response): JsonResponse
    {
        $this->getUsersParams($request);

        $users = $this->getGateway()->findUsersByName(
            $this->name,
            $this->from,
            $this->size
        );

        return $response->json([
            'from' => (int) $this->from,
            'size' => (int) $this->size,
            'data' => $users,
        ], $response::HTTP_OK);
    }

    public function getUserByUserName(Request $request, Response $response): JsonResponse
    {
        $this->getUsersParams($request);

        $users = $this->getGateway()->findUsersByUserName(
            $this->name,
            $this->from,
            $this->size
        );

        return $response->json([
            'from' => (int) $this->from,
            'size' => (int) $this->size,
            'data' => $users,
        ], $response::HTTP_OK);
    }

    private function getUsersParams(Request $request): void
    {
        $params = $request->getQueryParams();

        $this->name = (string) (empty($params['query'])) ? '' : $params['query'];
        $this->size = (int) (empty($params['size'])) ? 15 : $params['size'];
        $this->from = (int) (empty($params['from']))
            ? 0
            : $params['from'] * $this->size;
    }

    private function getGateway(): UsersGateway
    {
        if (null == $this->gateway) {
            $this->gateway = $this->container()->set(
                UsersGateway::class
            );
        }

        return $this->gateway;
    }
}
