<?php
/**
 * Created by PhpStorm.
 * User: baoxulong
 * Date: 2/11/18
 * Time: 19:20
 */

namespace src\Controllers;


class BaseController
{

    public function middleware($which = '')
    {
        $namespace = '\\Application\\Middleware\\';
        if (empty($which)){
            return true;
        }else{
             app($namespace.ucfirst($which));
        }
    }

}