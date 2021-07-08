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
    private $gateway;
    private string $query;
    private int $from;
    private int $size;

    public function getUserByName(Request $request, Response $response): JsonResponse
    {
        try {
            $this->getUsersParams($request);
            $users = $this->getGateway()->findUsersByName(
                $this->query,
                $this->from * $this->size,
                $this->size
            );

            if (empty($users)) {
                throw new \Exception('Nenhum usuário encontrado.', 404);
            }

            return $response->json(
                [
                    'from' => (int) $this->from,
                    'size' => (int) $this->size,
                    'data' => $users,
                ],
                $response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $response->json(
                [
                    'from' => (int) $this->from,
                    'size' => (int) $this->size,
                    'data' => [],
                ],
                $response::HTTP_NOT_FOUND ?? 500
            );
        }
    }

    public function getUserByUserName(Request $request, Response $response): JsonResponse
    {
        try {
            $this->getUsersParams($request);
            $users = $this->getGateway()->findUsersByUserName(
                $this->query,
                $this->from * $this->size,
                $this->size
            );

            if (empty($users)) {
                throw new \Exception('Nenhum usuário encontrado.', 404);
            }

            return $response->json(
                [
                    'from' => (int) $this->from,
                    'size' => (int) $this->size,
                    'data' => $users,
                ],
                $response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $response->json(
                [
                    'from' => (int) $this->from,
                    'size' => (int) $this->size,
                    'data' => [],
                ],
                $response::HTTP_NOT_FOUND ?? 500
            );
        }
    }

    private function getUsersParams(Request $request): void
    {
        $params = $request->getQueryParams();

        $this->query = (string) (empty($params['query'])) ? '' : $params['query'];
        $this->size = (int) (empty($params['size'])) ? 15 : $params['size'];
        $this->from = (int) (empty($params['from'])) ? 0 : $params['from'];
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
