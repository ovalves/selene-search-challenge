<?php
/**
 * @copyright   2019 - Selene
 * @author      Vinicius Oliveira <vinicius_o.a@live.com>
 * @category    Micro Framework
 * @since       2019-10-12
 */

use Exception;
use Selene\Gateway\GatewayAbstract;

class UsersGateway extends GatewayAbstract
{
    /**
     * Busca os usuarios utilizando o campo name.
     */
    public function findUsersByName(string $where, int $from, int $size): array
    {
        try {
            return $this->findUsers('name', $where, $from, $size);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Busca os usuarios utilizando o campo username.
     */
    public function findUsersByUserName(string $where, int $from, int $size): array
    {
        try {
            return $this->findUsers('username', $where, $from, $size);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Query generica para busca de usuarios por name ou username.
     */
    private function findUsers(string $column, string $where, int $from, int $size): array
    {
        try {
            return $this
                ->select([
                    'users.id',
                    'users.name',
                    'users.username',
                ])
                ->table('users')
                ->leftJoin('lista_relevancia_1', 'users.id', '=', 'lista_relevancia_1.id')
                ->leftJoin('lista_relevancia_2', 'users.id', '=', 'lista_relevancia_2.id')
                ->where(["{$column} like ?" => "%{$where}%"])
                ->order('lista_relevancia_1.id', 'DESC')
                ->order('lista_relevancia_2.id', 'DESC')
                ->order('users.id', 'ASC')
                ->limit($size)
                ->offset($from)
                ->execute()
                ->fetchAll(\PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception($e->getMessage() ?? 'Erro ao realizar a busca de usuários', $e->getCode() ?? 500);
        }
    }
}
