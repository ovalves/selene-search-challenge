<?php
/**
 * @copyright   2019 - Selene
 * @author      Vinicius Oliveira <vinicius_o.a@live.com>
 * @category    Micro Framework
 * @since       2019-10-12
 */

use Selene\Controllers\BaseController;
use Selene\Render\View;

class HomeController extends BaseController
{
    /**
     * Index Action.
     */
    public function index(): View
    {
        return $this->view()->render('home/home.php');
    }
}
