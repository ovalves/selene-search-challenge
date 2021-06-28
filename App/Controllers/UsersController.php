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

class UsersController extends BaseController
{
    public function getUserByName(Request $request, Response $response): mixed
    {
        $params = $request->getQueryParams();

        $name = (string) (empty($params['query'])) ? null : $params['query'];
        $from = (int) (empty($params['from'])) ? 0 : $params['from'];
        $size = (int) (empty($params['size'])) ? 15 : $params['size'];

        $users = $this
            ->select([
                'users.id',
                'users.name',
                'users.username',
            ])
            ->table('users')
            ->leftJoin('lista_relevancia_1', 'users.id', '=', 'lista_relevancia_1.id')
            ->leftJoin('lista_relevancia_2', 'users.id', '=', 'lista_relevancia_2.id')

            ->where(['name like ?' => "%{$name}%"])
            ->order('lista_relevancia_1.id', 'DESC')
            ->order('lista_relevancia_2.id', 'DESC')
            ->order('users.id', 'DESC')
            ->limit($size)
            ->offset($from)
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);

        echo '<pre>';
        echo json_encode($users, JSON_PRETTY_PRINT);
        exit;
    }

    public function getUserByUserName(Request $request): mixed
    {
        $params = $request->getQueryParams();

        $username = (string) (empty($params['query'])) ? null : $params['query'];
        $from = (int) (empty($params['from'])) ? 0 : $params['from'];
        $size = (int) (empty($params['size'])) ? 15 : $params['size'];

        $users = $this
            ->select('username')
            ->table('users')
            ->where(['username like ?' => "%{$username}%"])
            ->order('id', 'ASC')
            ->limit($size)
            ->offset($from)
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);

        echo '<pre>';
        echo json_encode($users, JSON_PRETTY_PRINT);
        exit();
    }
}
