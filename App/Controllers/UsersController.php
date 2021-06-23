<?php
/**
 * @copyright   2019 - Selene
 * @author      Vinicius Oliveira <vinicius_o.a@live.com>
 * @category    Micro Framework
 * @since       2019-10-12
 */

use Selene\Controllers\BaseController;
use Selene\Request\Request;

class UsersController extends BaseController
{
    public function getUserByName(Request $request): mixed
    {
        $params = $request->getQueryParams();

        $name = $params['query'] ?? null;
        $from = (int) $params['from'] ?? 0;
        $size = (int) $params['size'] ?? 15;

        $users = $this
            ->select('name')
            ->table('users')
            ->where(['name like ?' => "%{$name}%"])
            ->order('id', 'ASC')
            ->limit($size)
            ->offset($from)
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);

        echo '<pre>';
        echo json_encode($users, JSON_PRETTY_PRINT);
        exit();
    }

    public function getUserByUserName(Request $request): mixed
    {
        $params = $request->getQueryParams();

        $username = $params['query'] ?? null;
        $from = (int) $params['from'] ?? 0;
        $size = (int) $params['size'] ?? 15;

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
