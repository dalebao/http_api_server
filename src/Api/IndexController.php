<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2/10/18
 * Time: 16:56
 */

namespace src\Api;

use src\App\RequestHandler;
use src\Controllers\BaseController;

class IndexController extends BaseController
{

    public function index(RequestHandler $res)
    {
       return self::$database->table('hello')->select()->get();
    }
}