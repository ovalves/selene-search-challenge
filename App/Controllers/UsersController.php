<?php
/**
 * @copyright   2019 - Selene
 * @author      Vinicius Oliveira <vinicius_o.a@live.com>
 * @category    Micro Framework
 * @since       2019-10-12
 */

use Selene\Controllers\BaseController;
use Selene\Render\View;
use Selene\Request\Request;

class UsersController extends BaseController
{
    /**
     * Index Action.
     */
    public function index(Request $request): View
    {
        exit('request on controller');

        $params = $request->getQueryParams();

        $users = $this
            ->select('*')
            ->table('users')
            ->where(['title = ?' => 'matrix'])
            ->execute()
            ->fetchAll();

        /*
        * @example render view
        */
        return $this->view()->render('home/home.php');
    }
}
